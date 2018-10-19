<?php

namespace App\Services;


use App\Exceptions\UploadException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UploadServe
{
    /**
     * 表单的名字
     *
     * @var string
     */
    protected $fileInput = 'file';

    /**
     * 上传的最大大小
     *
     * @var int
     */
    protected $maxSize = 1024 * 1024 * 2;

    /**
     * @var Request
     */
    protected $request;

    /**
     * 允许上传的扩展
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * UploadServe constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 验证上传文件是否合法
     *
     * @throws UploadException
     */
    public function validate()
    {
        // 文件不合法
        if (! $this->request->hasFile($this->fileInput)) {
            throw new UploadException('文件不合法', StatusServe::HTTP_BAD_REQUEST);
        }

        // 有可能是单个文件，也有可能是多个文件
        $files = $this->request->file($this->fileInput);

        foreach (array_wrap($files) as $file) {
            $this->validateBase($file);
        }

        return $this;
    }

    /**
     * @param $path
     * @param $option
     * @return array
     */
    public function storeMulti($path, $option)
    {
        /**
         * @var $files UploadedFile[]
         */
        $files = $this->request->file($this->fileInput);

        $names = [];

        foreach ($files as $file) {
            $names[] = $file->store($path, $option);
        }

        return $names;
    }

    /**
     * 存储新文件
     *
     * @param       $path
     * @param array $option
     * @return false|string
     */
    public function store($path, $option = [])
    {
        $file = $this->request->file($this->fileInput);

        return $file->store($path, $option);
    }


    /**
     * 设置上传的文件表单名
     *
     * @param $input
     * @return $this
     */
    public function setFileInput($input)
    {
        $this->fileInput = $input;

        return $this;
    }

    /**
     * 设置可上传文件的格式
     *
     * @param array $extensions
     * @return $this
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }

    /**
     * 设置大小
     *
     * @param string $maxSize
     * @return UploadServe
     */
    public function setMaxSize($maxSize)
    {
        $metric = strtoupper(substr($maxSize, -1));
        $maxSize = (int) $maxSize;

        switch ($metric) {
            case 'K':
                $maxSize *= 1024;
                break;
            case 'M':
                $maxSize *= 1048576;
                break;
            case 'G':
                $maxSize *= 1073741824;
                break;
            default:
                break;
        }

        $this->maxSize = $maxSize;

        return $this;
    }

    /**
     * @param UploadedFile $file
     * @return $this
     * @throws UploadException
     */
    protected function validateBase(UploadedFile $file)
    {
        // 文件上传没有成功
        if (! $file->isValid()) {
            throw new UploadException('文件上传失败' . $file->getErrorMessage(), StatusServe::HTTP_BAD_REQUEST);
        }

        // 扩展不合法
        if (
            ! empty($this->extensions) &&
            ! in_array($file->getClientOriginalExtension(), $this->extensions)
        ) {
            throw new UploadException('文件不是有效的图片', StatusServe::HTTP_BAD_REQUEST);
        }

        if ($file->getClientSize() > $this->maxSize) {
            throw new UploadException('文件超过限制大小', StatusServe::HTTP_BAD_REQUEST);
        }

        return $this;
    }
}
