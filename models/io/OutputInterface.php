<?php
namespace io;

interface OutputInterface {
  public function ajax($data, $json = false, $jsonOpt = JSON_UNESCAPED_SLASHES);
  public function csv($data = [], $fileName = "");
}