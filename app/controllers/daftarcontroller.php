<?php

class DaftarController {

    public function index() {
        // Panggil view daftar.php
        require_once ROOT_PATH . 'app/views/auth/daftar.php';
    }

    public function process_register() {
        // Logika simpan data pendaftaran
    }
}