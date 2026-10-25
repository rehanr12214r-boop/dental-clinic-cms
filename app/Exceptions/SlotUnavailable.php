<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Raised while booking, when the requested time slot is (or has in the
 * meantime become) unavailable.
 */
class SlotUnavailable extends RuntimeException {}
