<?php
session_start();
require_once __DIR__ . '/auth.php';
echo generate_csrf_token();
