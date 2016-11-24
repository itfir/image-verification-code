## 使用方法
1、项目目录下 composer.json 文件内添加
    "psr-4": {
        "App\\": "app/",
        "Fir\\ImageVerificationCode\\": "vendor/fir/image-verification-code/src"
    }
2、App\Http\Kernel.php $middlewareGroups 内配置 \Fir\ImageVerificationCode\Middleware\ImageVerificationCode::class,;
3、使用方法
在需要图片验证码的表单内配置
<input name="ImageVerificationCode" value="{{ old('ImageVerificationCode') }}">
<img onclick="this.src='{{ route('ImageVerificationCode.Generate') }}?'+Math.random()" src="{{ route('ImageVerificationCode.Generate') }}">