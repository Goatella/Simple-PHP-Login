<?php

/**
 * Start the session to manage the sign in requests
 */
session_start();

// add database connection
require_once 'pdo.php';

// add functions
require_once 'helpers.php';