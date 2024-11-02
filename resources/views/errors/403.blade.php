@extends('layouts.error', [
    'title' => __('Forbidden'),
    'errorTitle' => __('Oops! Forbidden'),
    'errorMsg' => __('You are not allowed to access.'),
    'errorCode' => '403',
    'homeLink' => true,
])
