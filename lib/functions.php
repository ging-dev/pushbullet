<?php

/**
 * @internal
 * @return array{title: string, body: string, package_name: string}|false Trả về dữ liệu hoặc false
 */
function getNotificationMirrored(string $message)
{
    /**
     * @var array{push?: array{type: string, title: string, body: string, package_name: string}}
     */
    $data = json_decode($message, true);

    if (false === $push = $data['push'] ?? false) {
        return false;
    }

    if ('mirror' !== $push['type']) {
        return false;
    }

    return $push;
}
