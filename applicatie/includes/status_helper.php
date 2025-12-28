<?php
function statusTekst($status)
{
    $status = (int) $status;

    if ($status === 0) {
        return 'Nieuw';
    }

    if ($status === 1) {
        return 'In behandeling';
    }

    if ($status === 2) {
        return 'Bezorgd';
    }

    return 'Onbekend';
}
