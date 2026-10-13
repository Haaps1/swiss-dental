<?php
/* Shared <head>. Each page must set $pageTitle and $pageDesc before including this file. */
if (!isset($pageTitle)) { $pageTitle = 'Swiss Dental | Best Dental Clinic in Bangalore | Dr. Vinay Vindas'; }
if (!isset($pageDesc))  { $pageDesc  = "Swiss Dental, Bangalore — multi-disciplinary dental clinic led by Dr. Vinay Vindas since 2011."; }
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?></title>
<meta name="description" content="<?= $pageDesc ?>">
<link rel="icon" type="image/svg+xml" href="favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
</head>
