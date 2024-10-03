<?php

namespace Module\Product\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Module\Product\Models\Category;

class CategoryUploadCSV implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new category([
                'id'              => trim($row['id']),
                'product_type_id' => trim($row['product_type_id']),
                'parent_id'       => trim($row['parent_id']) != 0 ? trim($row['parent_id']) : null,
                'name'            => trim($row['name']),
                'slug'            => $this->slugify(trim($row['name'])),
                'order_level'     => trim($row['order_level']),
            ]);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
