@extends('layouts.error', [
    'title' => __('Under Maintenance'),
    'errorTitle' => __('Under Maintenance'),
    'errorMsg' => __('Sorry, we are now undergoing maintenance. Please check back soon.'),
    'errorCode' => '503',
    'homeLink' => false,
])
