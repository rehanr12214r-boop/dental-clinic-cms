<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Dentist;

class ClinicContentService
{
    /**
     * The clinic's public care team.
     *
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     short_name: string,
     *     role: string,
     *     experience: string,
     *     image: string,
     *     focus: string,
     *     bio: string,
     *     education: string,
     *     languages: string
     * }>
     */
    public function dentists(): array
    {
        // Prefer DB rows so admin edits are reflected instantly.
        $dbRows = Dentist::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($dbRows->isNotEmpty()) {
            return $dbRows->map(fn (Dentist $d) => $d->toContentArray())->all();
        }

        // Static fallback (shown before the seeder has run).
        return [
            [
                'slug' => 'james-morgan',
                'name' => 'Dr. James Morgan, DMD',
                'short_name' => 'Dr. James Morgan',
                'role' => 'Pediatric Dentist',
                'experience' => '5 years',
                'image' => 'team-james.jpg',
                'focus' => 'Preventive and paediatric dentistry',
                'bio' => 'James makes first visits feel unhurried and reassuring, with a gentle approach built around children and their families.',
                'education' => 'Doctor of Dental Medicine, University of California',
                'languages' => 'English, Spanish',
            ],
            [
                'slug' => 'harshall-gibbs',
                'name' => 'Dr. Harshall Gibbs, RDH',
                'short_name' => 'Dr. Harshall Gibbs',
                'role' => 'Dental Assistant',
                'experience' => '5 years',
                'image' => 'team-harshall.jpg',
                'focus' => 'Hygiene, prevention and patient comfort',
                'bio' => 'Harshall guides patients through every appointment with clear explanations, a calm manner and an eye for the smallest details.',
                'education' => 'Registered Dental Hygienist, Pacific Health College',
                'languages' => 'English',
            ],
            [
                'slug' => 'alex-peterson',
                'name' => 'Dr. Alex Peterson, DMD',
                'short_name' => 'Dr. Alex Peterson',
                'role' => 'Dental Hygienist',
                'experience' => '5 years',
                'image' => 'team-alex.jpg',
                'focus' => 'Restorative dentistry and hygiene',
                'bio' => 'Alex combines a precise clinical approach with a friendly chairside manner, helping nervous patients feel at ease from consultation to aftercare.',
                'education' => 'Doctor of Dental Medicine, West Coast Dental School',
                'languages' => 'English, German',
            ],
            [
                'slug' => 'nadal-james',
                'name' => 'Dr. Nadal James, DDS, MS',
                'short_name' => 'Dr. Nadal James',
                'role' => 'Periodontist & Implant',
                'experience' => '5 years',
                'image' => 'team-nadal.jpg',
                'focus' => 'Implantology and periodontal care',
                'bio' => 'Nadal plans implant and gum treatments around long-term health, using digital imaging to make every step predictable and comfortable.',
                'education' => 'Master of Science in Periodontics, Boston Dental Institute',
                'languages' => 'English, Arabic',
            ],
            [
                'slug' => 'lena-torres',
                'name' => 'Lena Torres, CDA',
                'short_name' => 'Lena Torres',
                'role' => 'Dental Assistant',
                'experience' => '5 years',
                'image' => 'team-lena.jpg',
                'focus' => 'Chairside care and treatment coordination',
                'bio' => 'Lena is often the first friendly face patients meet, keeping appointments organised and making sure every question is answered before treatment begins.',
                'education' => 'Certified Dental Assistant, City College',
                'languages' => 'English, Spanish',
            ],
            [
                'slug' => 'andrew-flintoff',
                'name' => 'Dr. Andrew Flintoff, DDS',
                'short_name' => 'Dr. Andrew Flintoff',
                'role' => 'Cosmetic Specialist',
                'experience' => '5 years',
                'image' => 'team-andrew.jpg',
                'focus' => 'Cosmetic dentistry and smile design',
                'bio' => "Andrew takes a conservative, natural-looking approach to cosmetic care, designing treatments that respect each patient's features and goals.",
                'education' => 'Doctor of Dental Surgery, Royal College of Dental Medicine',
                'languages' => 'English',
            ],
        ];
    }

    /**
     * Find a dentist by slug.
     *
     * @return array{
     *     slug: string,
     *     name: string,
     *     short_name: string,
     *     role: string,
     *     experience: string,
     *     image: string,
     *     focus: string,
     *     bio: string,
     *     education: string,
     *     languages: string
     * }|null
     */
    public function dentist(string $slug): ?array
    {
        // Try DB first (admin-editable rows).
        $dbRow = Dentist::query()->where('slug', $slug)->first();
        if ($dbRow !== null) {
            return $dbRow->toContentArray();
        }

        // Fallback: static list (before seeder has run).
        foreach ($this->dentists() as $dentist) {
            if ($dentist['slug'] === $slug) {
                return $dentist;
            }
        }

        return null;
    }

    /**
     * The journal articles shown on the blog index and detail pages.
     *
     * @return list<array{
     *     slug: string,
     *     title: string,
     *     category: string,
     *     image: string,
     *     excerpt: string,
     *     date: string,
     *     read_time: string,
     *     author: string,
     *     author_role: string,
     *     author_image: string,
     *     sections: list<array{heading: string, body: list<string>}>,
     *     quote: string,
     *     quote_author: string
     * }>
     */
    public function posts(): array
    {
        // Prefer DB rows so admin edits are reflected instantly.
        $dbRows = BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        if ($dbRows->isNotEmpty()) {
            return $dbRows->map(fn (BlogPost $p) => $p->toContentArray())->all();
        }

        // Static fallback (shown before the seeder has run).
        return [
            [
                'slug' => 'benefits-of-early-orthodontic-checkups-for-kids',
                'title' => 'Benefits of Early Orthodontic Checkups for Kids.',
                'category' => 'Orthodontics',
                'image' => 'blog-1.jpg',
                'excerpt' => 'An early orthodontic checkup can catch small issues before they become complex, giving growing smiles the best possible start.',
                'date' => '09 March 2025',
                'read_time' => '4 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. Why Early Checkups Matter',
                        'body' => [
                            'The first orthodontic checkup is about observation rather than treatment. By looking at jaw growth, bite patterns and the space available for adult teeth, we can spot issues while they are still simple to guide.',
                        ],
                    ],
                    [
                        'heading' => '2. The Right Time to Start',
                        'body' => [
                            'Most children benefit from a first assessment around age seven, when a mix of baby and adult teeth makes growth patterns easier to read. That does not mean treatment starts immediately; often the best plan is simply to monitor.',
                        ],
                    ],
                    [
                        'heading' => '3. A Gentler Path to Straight Teeth',
                        'body' => [
                            'Early guidance can reduce the need for more complex treatment later. It may create room for crowded teeth, correct a crossbite or help a child stop a habit that is affecting their bite.',
                        ],
                    ],
                    [
                        'heading' => '4. Building Confidence Early',
                        'body' => [
                            'Children who understand their teeth from a young age tend to feel more comfortable in the dental chair. A calm first visit sets the tone for a lifetime of healthy habits and confident smiles.',
                        ],
                    ],
                ],
                'quote' => 'The best orthodontic result often begins with a simple checkup, long before braces are needed.',
                'quote_author' => 'Dr. James Morgan',
            ],
            [
                'slug' => 'how-dental-implants-improve-oral-health-long-term',
                'title' => 'How Dental Implants Improve Oral Health Long-Term.',
                'category' => 'Dental Implants',
                'image' => 'blog-2.jpg',
                'excerpt' => 'Implants do more than fill a gap. They protect bone, support neighbouring teeth and restore comfortable everyday function.',
                'date' => '09 March 2025',
                'read_time' => '5 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. More Than a Replacement Tooth',
                        'body' => [
                            'A dental implant replaces the root as well as the visible crown. That root-like support helps preserve the jawbone and keeps the surrounding teeth from drifting into the empty space.',
                        ],
                    ],
                    [
                        'heading' => '2. Protecting the Jawbone',
                        'body' => [
                            'Bone responds to pressure. Without a tooth root, the bone beneath a gap can gradually shrink. An implant provides the stimulation needed to maintain bone volume and facial structure over time.',
                        ],
                    ],
                    [
                        'heading' => '3. Comfortable, Confident Function',
                        'body' => [
                            'Because implants are fixed in place, they do not move or click like a loose denture. Patients can eat, speak and smile with the same confidence they had before losing a tooth.',
                        ],
                    ],
                    [
                        'heading' => '4. A Long-Term Investment',
                        'body' => [
                            'With good hygiene and regular reviews, an implant can last for many years. Planning is personalised around bone health, medical history and the way you use your teeth every day.',
                        ],
                    ],
                ],
                'quote' => 'A well-planned implant is not just a restoration; it is part of a healthier, more stable mouth.',
                'quote_author' => 'Dr. Nadal James',
            ],
            [
                'slug' => 'simple-cosmetic-dentistry-options-for-everyday-smiles',
                'title' => 'Simple Cosmetic Dentistry Options for Everyday Smiles.',
                'category' => 'Cosmetic Dentistry',
                'image' => 'blog-3.jpg',
                'excerpt' => 'Simple cosmetic dentistry options designed to enhance your everyday smile with natural, confident results.',
                'date' => '09 March 2025',
                'read_time' => '5 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. What Is Simple Cosmetic Dentistry?',
                        'body' => [
                            'Simple cosmetic dentistry focuses on enhancing the appearance of your smile through quick, effective and minimally invasive treatments. Unlike complex procedures that may require multiple visits or extensive work, these options are designed to deliver noticeable improvements with less time and discomfort. They are ideal for patients who want to correct small imperfections such as discoloration, uneven edges or minor gaps while maintaining a natural look. This approach makes achieving a confident smile more accessible for everyday individuals.',
                        ],
                    ],
                    [
                        'heading' => '2. Easy Treatments with Big Impact',
                        'body' => [
                            'A variety of simple treatments can significantly improve your smile without the need for major dental work. Procedures like professional teeth whitening, dental bonding and subtle reshaping can brighten teeth, fix small chips and create a more balanced appearance. Despite being straightforward, these treatments often produce immediate and visible results. With advancements in dental technology, these options are now more precise, efficient and comfortable than ever before, making it easier to achieve a refreshed smile in just one or two visits.',
                        ],
                    ],
                    [
                        'heading' => '3. Designed for Everyday Confidence',
                        'body' => [
                            'Simple cosmetic dentistry is all about helping you feel more confident in your daily life. Whether you are speaking in meetings, taking photos or simply smiling in social situations, even small improvements can make a big difference in how you feel. These treatments are tailored to enhance your natural features rather than drastically changing your appearance, ensuring that your smile still feels like you — just brighter and more refined. It is a practical and approachable way to boost self-confidence without undergoing extensive procedures.',
                        ],
                    ],
                    [
                        'heading' => '4. Comfortable, Affordable Care',
                        'body' => [
                            'One of the biggest advantages of simple cosmetic dentistry is its affordability and convenience. Compared to more advanced cosmetic treatments, these options are generally more budget-friendly while still delivering excellent results. Most procedures involve minimal discomfort and require little to no recovery time, allowing you to return to your normal routine quickly. Dentists also prioritise patient comfort by using modern, gentle techniques, making the entire experience smooth and stress-free from start to finish.',
                        ],
                    ],
                ],
                'quote' => 'A confident smile does not require complex treatments — sometimes, the simplest changes make the biggest difference.',
                'quote_author' => 'James Anderson',
            ],
            [
                'slug' => 'common-myths-about-root-canal-treatments-explained',
                'title' => 'Common Myths About Root Canal Treatments Explained.',
                'category' => 'Root Canal',
                'image' => 'blog-4.jpg',
                'excerpt' => 'Root canals have a reputation they no longer deserve. Here is what modern treatment actually feels like.',
                'date' => '09 March 2025',
                'read_time' => '4 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. The Pain Comes From Infection',
                        'body' => [
                            'Most root canal pain is caused by the infection and pressure inside the tooth before treatment begins. Modern anaesthesia and gentle techniques make the procedure itself comfortably numb and surprisingly uneventful.',
                        ],
                    ],
                    [
                        'heading' => '2. Saving the Natural Tooth',
                        'body' => [
                            'A root canal removes infected tissue while keeping the structure of the tooth. Keeping your natural tooth can be healthier and more economical than replacing it, and it helps maintain normal biting and jaw function.',
                        ],
                    ],
                    [
                        'heading' => '3. Treatment Is Usually Straightforward',
                        'body' => [
                            'Many root canals are completed in one visit. Your dentist will explain the steps, check in throughout the appointment and provide clear aftercare instructions so you know exactly what to expect.',
                        ],
                    ],
                    [
                        'heading' => '4. Aftercare Makes the Difference',
                        'body' => [
                            'Mild tenderness for a day or two is normal. Avoiding very hard foods, taking any recommended pain relief and attending your follow-up review all help the tooth settle and protect the long-term result.',
                        ],
                    ],
                ],
                'quote' => 'The stories are often scarier than the treatment. A calm, well-anaesthetised root canal is a very ordinary appointment.',
                'quote_author' => 'Dr. Alex Peterson',
            ],
            [
                'slug' => 'what-to-expect-during-a-dental-implant-procedure',
                'title' => 'What to Expect During a Dental Implant Procedure.',
                'category' => 'Dental Implants',
                'image' => 'blog-5.jpg',
                'excerpt' => 'From the first scan to the final crown, a clear walkthrough of the implant journey and how we keep it comfortable.',
                'date' => '09 March 2025',
                'read_time' => '5 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. Planning Starts with Imaging',
                        'body' => [
                            'A 3D scan shows the shape of the bone, the position of nearby nerves and the best angle for the implant. This planning stage is what makes the procedure predictable and conservative.',
                        ],
                    ],
                    [
                        'heading' => '2. A Comfortable Surgical Appointment',
                        'body' => [
                            'The implant is placed under local anaesthesia. Most patients describe pressure rather than pain, and the appointment is often shorter than they expect. Sedation options are available for anxious patients.',
                        ],
                    ],
                    [
                        'heading' => '3. Healing and Integration',
                        'body' => [
                            'Over the following weeks the bone integrates with the implant surface. You will have a review to confirm healing is on track before the final crown is made and fitted.',
                        ],
                    ],
                    [
                        'heading' => '4. Looking After Your New Tooth',
                        'body' => [
                            'An implant needs the same care as a natural tooth: brushing, interdental cleaning and regular professional reviews. With good habits, it can serve you comfortably for many years.',
                        ],
                    ],
                ],
                'quote' => 'Good implant care is mostly good planning. The surgical appointment is only one part of the journey.',
                'quote_author' => 'Dr. Nadal James',
            ],
            [
                'slug' => 'how-cosmetic-dentistry-can-improve-your-confidence',
                'title' => 'How Cosmetic Dentistry Can Improve Your Confidence.',
                'category' => 'Cosmetic Dentistry',
                'image' => 'blog-6.jpg',
                'excerpt' => 'Small, considered changes can make a meaningful difference to the way you feel about your smile.',
                'date' => '09 March 2025',
                'read_time' => '4 min read',
                'author' => 'James Anderson',
                'author_role' => 'Story Teller',
                'author_image' => 'team-james.jpg',
                'sections' => [
                    [
                        'heading' => '1. Start with What Bothers You',
                        'body' => [
                            'Cosmetic dentistry works best when it begins with your own priorities. A consultation gives you space to describe what you notice in photographs or in the mirror, without pressure to change anything.',
                        ],
                    ],
                    [
                        'heading' => '2. Natural-Looking Improvements',
                        'body' => [
                            'Modern bonding, whitening and alignment options are designed to look like you at your healthiest. We match shades and shapes carefully so the result feels balanced rather than obvious.',
                        ],
                    ],
                    [
                        'heading' => '3. Confidence in Everyday Moments',
                        'body' => [
                            'Feeling comfortable with your smile can change how you approach meetings, photographs and social occasions. The goal is not perfection; it is a smile you no longer feel you need to hide.',
                        ],
                    ],
                    [
                        'heading' => '4. A Plan You Can Say Yes To',
                        'body' => [
                            'You will always receive clear options, realistic timelines and transparent pricing. There is no obligation to proceed, and we are happy to stage treatment over time if that suits you better.',
                        ],
                    ],
                ],
                'quote' => 'The most successful cosmetic work is the kind that still looks completely like you.',
                'quote_author' => 'Dr. Andrew Flintoff',
            ],
        ];
    }

    /**
     * Find a journal article by slug.
     *
     * @return array{
     *     slug: string,
     *     title: string,
     *     category: string,
     *     image: string,
     *     excerpt: string,
     *     date: string,
     *     read_time: string,
     *     author: string,
     *     author_role: string,
     *     author_image: string,
     *     sections: list<array{heading: string, body: list<string>}>,
     *     quote: string,
     *     quote_author: string
     * }|null
     */
    public function post(string $slug): ?array
    {
        // Try DB first.
        $dbRow = BlogPost::query()->where('slug', $slug)->first();
        if ($dbRow !== null) {
            return $dbRow->toContentArray();
        }

        // Fallback: static list.
        foreach ($this->posts() as $post) {
            if ($post['slug'] === $slug) {
                return $post;
            }
        }

        return null;
    }
}
