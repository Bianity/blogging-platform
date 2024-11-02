@extends('layouts.error', [
    'title' => __('Too Many Requests'),
    'errorTitle' => __('Too Many Requests'),
    'errorMsg' => __('Just slow down and luck will be on your side!'),
    'errorCode' => '419',
    'homeLink' => true,
])
