<?php

class Uuid {
  private static $uuid;

  public static function next() {
    self::$uuid++;
    return 'uuid-' . self::$uuid;
  }
}

function uuid() {
  return Uuid::next();
}
