<?php

class AuthClient {

    private string $fileClients;

    public function __construct()
    {
        $this->fileClients = "/var/www/html/botiga/gestio/clients/clients";
    }

    public function login(string $username, string $password): bool
    {
        session_start(); // IMPORTANTÍSIMO: asegurar la sesión aquí

        if (!file_exists($this->fileClients)) {
            error_log("AuthClient: No existe el archivo de clientes");
            return false;
        }

        $lines = file($this->fileClients, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            $parts = explode(";", $line);

            if (count($parts) < 10) continue;

            [$user, $id, $hash] = $parts;

            if ($user === $username) {

                if (password_verify($password, $hash)) {

                    // 🔥🔥🔥 AQUI SE GUARDAN LAS VARIABLES DE SESION 🔥🔥🔥
                    $_SESSION["username"] = $user;
                    $_SESSION["client_user"] = $user;
                    $_SESSION["client_id"] = $id;
                    $_SESSION["role"] = "client";

                    error_log("AuthClient: Sesión guardada correctamente");

                    return true;
                }
            }
        }

        return false;
    }
}
