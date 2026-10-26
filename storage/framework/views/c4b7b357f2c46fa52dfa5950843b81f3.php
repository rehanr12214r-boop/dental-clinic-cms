<?php
    use App\Models\Setting;

    $cost = number_format((float) ($appointment->treatment?->cost ?? 0), 2);

    // Defaults let the patient portal reuse this view without rebuilding
    // every value the admin controller provides.
    $settings = $settings ?? array_merge(Setting::defaults(), Setting::allKeyed());
    $receiptNumber ??= 'R-'.str_pad((string) $appointment->getKey(), 5, '0', STR_PAD_LEFT);
    $issuedAt ??= now();
    $backUrl ??= route('admin.dashboard');
    $backLabel ??= 'Back to dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt <?php echo e($receiptNumber); ?> · <?php echo e($settings['clinic_name']); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <style>
        @media print {
            @page { margin: 10mm; }
            body { background: #fff !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 py-10 font-sans text-slate-900 antialiased print:bg-white print:py-0">
<div class="mx-auto max-w-md px-4 print:max-w-none print:px-0">

    
    <div class="mb-4 flex items-center justify-between gap-3 print:hidden">
        <a href="<?php echo e($backUrl); ?>"
           class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            <?php echo e($backLabel); ?>

        </a>
        <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Z"/>
            </svg>
            Print receipt
        </button>
    </div>

    
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200 print:rounded-none print:p-0 print:shadow-none print:ring-0">
        
        <div class="text-center">
            <span class="mx-auto grid size-12 place-items-center rounded-2xl bg-teal-700 text-2xl shadow-sm ring-1 ring-slate-900/10 print:shadow-none">🦷</span>
            <h1 class="mt-3 text-lg font-bold tracking-tight"><?php echo e($settings['clinic_name']); ?></h1>
            <p class="mt-0.5 text-xs text-slate-500"><?php echo e($settings['clinic_address']); ?></p>
            <p class="text-xs text-slate-500">Tel: <?php echo e($settings['clinic_phone']); ?></p>
        </div>

        <div class="mt-6 border-t-2 border-dashed border-slate-300"></div>

        
        <div class="mt-4 flex items-start justify-between text-xs">
            <div>
                <p class="font-semibold uppercase tracking-wider text-slate-400">Receipt</p>
                <p class="mt-0.5 font-mono text-sm font-bold"><?php echo e($receiptNumber); ?></p>
            </div>
            <div class="text-right">
                <p class="font-semibold uppercase tracking-wider text-slate-400">Issued</p>
                <p class="mt-0.5 font-medium"><?php echo e($issuedAt->format('M j, Y · g:i A')); ?></p>
            </div>
        </div>

        
        <div class="mt-5 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200 print:bg-white print:ring-slate-300">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Patient</p>
            <p class="mt-1 text-sm font-bold"><?php echo e($appointment->patient_name); ?></p>
            <p class="mt-0.5 text-xs text-slate-500">
                <?php echo e($appointment->patient_phone); ?><?php if($appointment->patient_age): ?> · <?php echo e($appointment->patient_age); ?> years old <?php endif; ?>
            </p>
        </div>

        
        <table class="mt-5 w-full text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-400">
                <th class="pb-2 font-semibold">Treatment</th>
                <th class="pb-2 font-semibold">Date &amp; time</th>
                <th class="pb-2 text-right font-semibold">Fee</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-t border-slate-200">
                <td class="py-3">
                    <p class="font-semibold"><?php echo e($appointment->treatment?->name); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($appointment->treatment?->duration_minutes); ?> min</p>
                </td>
                <td class="py-3">
                    <p class="font-medium"><?php echo e($appointment->dateLabel('M j, Y')); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($appointment->timeLabel()); ?></p>
                </td>
                <td class="py-3 text-right font-semibold">$<?php echo e($cost); ?></td>
            </tr>
            </tbody>
        </table>

        <div class="mt-4 flex items-center justify-between border-t-2 border-dashed border-slate-300 pt-4">
            <p class="text-sm font-semibold text-slate-500">Total paid</p>
            <p class="text-xl font-bold">$<?php echo e($cost); ?></p>
        </div>

        <p class="mt-4 rounded-lg bg-emerald-50 px-3 py-2 text-center text-xs font-semibold text-emerald-700 ring-1 ring-emerald-600/20 print:bg-white print:ring-emerald-300">
            Paid in full — thank you!
        </p>

        
        <div class="mt-10">
            <div class="ml-auto w-48 border-t border-slate-400 pt-1.5 text-center">
                <p class="text-xs font-semibold text-slate-700"><?php echo e($settings['doctor_name']); ?></p>
                <p class="text-[11px] text-slate-400">Authorized signature</p>
            </div>
        </div>

        <p class="mt-8 text-center text-[11px] text-slate-400">
            Thank you for choosing <?php echo e($settings['clinic_name']); ?>. See you at your next visit!
        </p>
    </div>

    <p class="mt-4 text-center text-[11px] text-slate-400 print:hidden">
        Tip: use your browser's print dialog — the layout is formatted for A4 and thermal printers.
    </p>
</div>
</body>
</html>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/receipts/show.blade.php ENDPATH**/ ?>