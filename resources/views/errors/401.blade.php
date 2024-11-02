@extends('layouts.error', [
    'title' => __('Unauthorized'),
    'errorTitle' => __('Unauthorized'),
    'errorMsg' => __('You authentication data not sent.'),
    'errorCode' => '401',
    'homeLink' => true,
])
