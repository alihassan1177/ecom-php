<?php 

namespace App\enums;

abstract class OrderStatus{
  public static const PENDING = 1;
  public static const PROCESSING = 2;
  public static const COMPLETED = 3;
  public static const ON_HOLD = 4;
  public static const REFUNDED = 5;
  public static const CANCELLED = 6;
  public static const FAILED = 7;
}
