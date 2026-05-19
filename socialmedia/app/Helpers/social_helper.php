<?php

if (! function_exists('e_text')) {
    function e_text(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('profile_picture_url')) {
    function profile_picture_url(?string $fileName): string
    {
        if ($fileName && $fileName !== 'default.png') {
            return base_url('profile-picture/' . $fileName);
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160"><rect width="160" height="160" rx="80" fill="#e8eef7"/><circle cx="80" cy="62" r="30" fill="#93a4bd"/><path d="M34 144c8-31 31-48 46-48s38 17 46 48" fill="#93a4bd"/></svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

if (! function_exists('short_date')) {
    function short_date(?string $date): string
    {
        if (! $date) {
            return '';
        }

        return date('M d, Y h:i A', strtotime($date));
    }
}

if (! function_exists('active_nav')) {
    function active_nav(string $path): string
    {
        return trim(uri_string(), '/') === trim($path, '/') ? 'active' : '';
    }
}
