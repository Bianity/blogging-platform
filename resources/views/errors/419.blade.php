@extends('layouts.error', [
    'title' => __('Page Expired'),
    'errorTitle' => __('Page Expired'),
    'errorMsg' => __('Sorry, your session has expired. Please refresh and try again.'),
    'errorCode' => '419',
    'homeLink' => true,
])
