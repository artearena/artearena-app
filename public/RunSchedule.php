<?php
// Arquivo: run_schedule.php

// Chama o comando do Laravel usando exec()
exec('php ../artisan schedule:run 1>> /dev/null 2>&1');