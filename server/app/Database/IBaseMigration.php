<?php
namespace App\Database;

use App\Database\Connection;

interface IBaseMigration {

    protected const TABLE = null;

    function __construct();

    function up();

    function down();

    function getWritedMigration():String;

    function writeMigration($mainSql);

}