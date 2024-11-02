@extends('layouts.error', [
    'title' => 'Server error',
    'errorTitle' => __('This page istn`t working'),
    'errorMsg' => __('Internal Server Error'),
    'errorCode' => '500',
    'homeLink' => false,
])
