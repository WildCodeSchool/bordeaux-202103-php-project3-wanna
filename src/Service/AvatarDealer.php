<?php


namespace App\Service;


class AvatarDealer
{
    public function saveUserNewAvatar($user, $imgdata)
    {
        $imgDirName = './uploads/images/avatar/';
        $imgName = 'avatar' . $user->getId() . '.png';

        list($type, $imgdata) = explode(';', $imgdata);
        list(, $imgdata) = explode(',', $imgdata);
        $data = base64_decode($imgdata);
        file_put_contents($imgDirName . $imgName, $data);

        $oldfile = $user->getAvatar()->getName();
        unlink($imgDirName . $oldfile);

        return $imgName;
    }

}
