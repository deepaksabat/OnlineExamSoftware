<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Image;
class ImageSettings extends Model
{
    ////////////////////////////
    // Profile Upload Options //
    ////////////////////////////
    protected $profilePicsPath      = "uploads/users/";
	protected $profilePicsThumbnailpath = "uploads/users/thumbnail/";
    protected $thumbnailSize = 50;
    protected $profilePicSize = 140;
    protected $defaultProfilePicPath           = "uploads/users/default.png";
    protected $defaultprofilePicsThumbnailpath = "uploads/users/thumbnail/default.png";
	protected $settingsImagePath = "uploads/settings/";

    ///////////////////////////////////
    // Image Question upload options //
    ///////////////////////////////////
    protected $examImagepath                = "uploads/exams/";
    protected $examImageSize                = 600;
    protected $examMaxFileSize              = 10000;
    
    


    // protected $defaultProfilePicPath           = "uploads/exams/default.png";
    // protected $defaultprofilePicsThumbnailpath = "uploads/exams/thumbnail/default.png";


    /**
     * If Needed can change the Profile Pics Path
     * @param [string] $path [description]
     * @return  void
     */
	public function setProfilePicsPath($path)
	{
		$this->profilePicsPath = $path;
	}
    
    /**
     * Returns the Profile Pics Path
     * @return [string] [description]
     */
    public function getDefaultProfilePicPath()
    {
        return $this->defaultProfilePicPath;
    }

      /**
     * Returns the Profile Pics Path
     * @return [string] [description]
     */
    public function getDefaultprofilePicsThumbnailpath()
    {
        return $this->defaultprofilePicsThumbnailpath;
    }


    /**
     * Returns the Profile Pics Path
     * @return [string] [description]
     */
    public function getProfilePicsPath()
    {
        return $this->profilePicsPath;
    }

    /**
     * Returns the Profile Thumbnail Path
     * @return [string] [description]
     */
    public function getProfilePicsThumbnailpath()
    {
        return $this->profilePicsThumbnailpath;
    }

    /**
     * Returns the Thumbnail size
     * @return [numeric] [description]
     */
    public function getThumbnailSize()
    {
        return $this->thumbnailSize;
    }

    /**
     * Returns the Profile Pic size
     * @return [numeric] [description]
     */
    public function getProfilePicSize()
    {
    	return $this->profilePicSize;
    }

    /**
     * If needed can change the Thumb size
     * @param [Integer] $size [description]
     * @return  void [<description>]
     */
    public function setThumbnailSize($size)
    {
    	$this->thumbnailSize = $size;
    }

  
    public function getExamImagePath()
    {
        return $this->examImagepath;
    }

    public function getExamImageSize()
    {
        return $this->examImageSize;
    }

    public function getExamMaxFilesize()
    {
        return $this->examMaxFileSize;
    }

    public function getSettingsImagePath()
    {
        return $this->settingsImagePath;
    }


    // public function saveImage(UploadedFile $file, User $user, $path)
    // {
		  // $destinationPath = $path;
    //       $fileName = $user->name.'_'.$user->id.'.'.$file->photo->guessClientExtension();
    //       ;
    //       $file->move($destinationPath, $fileName);
    //       $user->image = $fileName;
    //       Image::make($destinationPath.$fileName)->fit($this->getThumbnailSize())->save($destinationPath.$fileName);
    //       $user->save();		    	
    // }

}
