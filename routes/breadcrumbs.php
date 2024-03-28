<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('index'));
});


// Home > Product Details
Breadcrumbs::for('product.details', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Product Details', route('product.details', ''));
});

// Home > Product Details
Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Cart', route('cart'));
});
