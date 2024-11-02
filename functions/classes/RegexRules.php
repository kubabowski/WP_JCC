<?php

  namespace ThemeClasses;

  class RegexRules
  {
    // unescaped '/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';
    const EMAIL = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';
    const NUMBER = '/^\d+$/';
    const SLUG = '/^([\w_]+-)*[\w_]+$/';
    const TEXT = '/^.*$/';
    const MULTILINE = '/^(.|\n)*$/';
    const LANG = '/^\w{2}$/';
  }

