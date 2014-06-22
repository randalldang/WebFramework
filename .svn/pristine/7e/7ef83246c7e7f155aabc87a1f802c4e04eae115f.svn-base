<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:validation-code!');
}

/**
 * Text_CAPTCHA 验证码产生器。该类包装了产生图片验证码的逻辑。
 */

class ValidationCode {
    public static function generateCode() {
        list($usec, $sec) = explode(' ', microtime());

        srand((float) $sec + ((float) $usec * 100000));//播下一个生成随机数字的种子，以方便下面随机数生成的使用

        $im = imagecreate(90,20) or die('Cannot initialize new GD image stream!');   //制定图片背景大小
        $red = imagecolorallocate($im, 255, 0, 0); //设定三种颜色
        $white = imagecolorallocate($im, 255, 255, 255);
        $gray = imagecolorallocate($im, 200, 200, 200);

        imagefill($im, 0, 0, $white);

        //生成数字和字母混合的验证码方法
        $ychar = '0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
        $list = explode(',', $ychar);

        $authnum = '';
        $authnum_in_cookie = '';
        for($i=0; $i<4; $i++) {
            $randnum = rand(0, 60); //61 是数字和大小写字母的数量和。
            $authnum .= trim($list[$randnum]) . ' ';//end  加入一个空格
            $authnum_in_cookie .= trim($list[$randnum]);
        }

        //将验证码放入COOKIE中
        $authnum_in_cookie = md5(strtolower($authnum_in_cookie));
        setcookie('validation_code', $authnum_in_cookie, time() + 3600, '/', var_get('cookie_domain'));

        imagestring($im, 5, 10, 3, $authnum, $red);
        //用col颜色将字符串s画到image所代表的图像的x，y座标处（图像的左上角为0,0）。
        //如果 font 是 1，2，3，4 或 5，则使用内置字体
        for($i=0; $i<400; $i++) { //加入干扰象素 {
            $randcolor = imagecolorallocate($im, rand(0, 255),rand(0, 255),rand(0, 255));
            imagesetpixel($im, rand()%90 , rand()%30 , $gray);
        }

        Imagepng($im);
        ImageDestroy($im);
    }

    public static function getGeneratedCode() {
        return isset($_COOKIE['validation_code']) ? $_COOKIE['validation_code'] : NULL;
    }

    public static function clearGeneratedCode() {
        $_COOKIE['validation_code'] = NULL;
    }
}
?>
