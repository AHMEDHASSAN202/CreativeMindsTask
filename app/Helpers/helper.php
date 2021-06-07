<?php

/**
 * Generate Verification Code
 *
 * @return int
 */
function generateVerifyCode() {
    return mt_rand(11111, 99999);
}

/**
 * Generate Alert Array
 *
 * @param $class
 * @param $title
 * @param $icon
 * @return array[]
 */
function makeAlert($class, $title, $icon) {
    return [
        'alert' => [
            'class' => $class,
            'title' => $title,
            'icon'  => $icon
        ],
    ];
}
