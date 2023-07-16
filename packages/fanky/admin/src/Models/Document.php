<?php

namespace Fanky\Admin\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFile;

    protected $fillable = ['product_id', 'name', 'src', 'order'];

    const UPLOAD_URL = '/uploads/docs/';
    const DOC_ICON = '/adminlte/doc_icon.png';
    const PDF_ICON = '/adminlte/pdf_icon.png';
    const UNKNOWN_ICON = '/adminlte/unknown_icon.png';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getIconImage()
    {
        $arr = explode('.', $this->src);
        $ext = array_pop($arr);
        if (in_array($ext, ['doc', 'docx'])) {
            return self::DOC_ICON;
        }
        if (in_array($ext, ['pdf'])) {
            return self::PDF_ICON;
        }
        return self::UNKNOWN_ICON;
    }

    public function getDocSrcAttribute()
    {
        return self::UPLOAD_URL . $this->src;
    }


}
