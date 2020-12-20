<?php

namespace common\models;

class Enum {

    const TYPE_DOCUMENT = 1;
    const TYPE_AUDIO = 2;
    // Yes no answers
    const ANSWER_NO = 0;
    const ANSWER_YES = 1;

    public static function itemAlias($type = '', $index = null) {
        $arr = [
            'types' => [
                self::TYPE_DOCUMENT => "Document(docx,doc,pdf)",
                self::TYPE_AUDIO => "Audio file",
            ],
        ];
        if (isset($index))
            return isset($arr[$type][$index]) ? $arr[$type][$index] : false;
        else
            return isset($arr[$type]) ? $arr[$type] : false;
    }

}
