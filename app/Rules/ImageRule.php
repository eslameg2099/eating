<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class ImageRule implements Rule
{
    use ValidatesAttributes;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $file = $value;

        if (is_string($value)) {
            $file = $this->convertToFile($file);
        }

        return $this->validateImage($attribute, $file);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.image');
    }

    /**
     * @param string $value
     *
     * @return File
     */
    protected function convertToFile(string $value): File
    {
        if (strpos($value, ';base64') !== false) {
            [, $value] = explode(';', $value);
            [, $value] = explode(',', $value);
        }

        $binaryData = base64_decode($value);
        $tmpFile = tempnam(sys_get_temp_dir(), 'base64validator');
        file_put_contents($tmpFile, $binaryData);

        return new File($tmpFile);
    }
}
