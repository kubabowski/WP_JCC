<?php

function json_to_attr($phpData) {
  return htmlentities(json_encode($phpData));
  // return htmlspecialchars(json_encode($phpData), ENT_QUOTES, 'UTF-8');
}
