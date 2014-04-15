<?php

    function image_thumb($image_file , $width,$height, $section = "logos")
    {
        #Get the CodeIgniter super object
        $CI =& get_instance();

        $image_path = "muploads/".$section."/".$image_file;

        #Path to image thumbnail
        $thumb_file = $width.'_'.$height.'_'.$image_file;
        $image_thumb = dirname($image_path) . '/thumbs/'.$thumb_file;


        if( ! file_exists($image_thumb))
        {
            # LOAD LIBRARY
            $CI->load->library('image_lib');

            # Load the database library
            $CI->load->database();

            #CONFIGURE IMAGE LIBRARY
            $config['image_library']    = 'gd2';
            $config['source_image']     = $image_path;
            $config['new_image']        = $image_thumb;
            $config['maintain_ratio']   = TRUE;
            $config['height']           = $height;
            $config['width']            = $width;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();

            #save thumb path in relation to original image in db
            $thumb_obj = array(
                    "original_image" => $image_file,
                    "thumb"          => $thumb_file
                ); 
            $CI->db->insert("image_thumbs",$thumb_obj);
        }
    
    return $image_thumb;
    }


    function delete_file($image_file, $section = "logos") 
    {
        #Get the CodeIgniter super object
        $CI =& get_instance();

        $image_path = "muploads/".$section."/".$image_file;
        $thumb_path = "muploads/".$section."/thumbs/";

        if(file_exists($image_path))
        {            
            # Load the database library
            $CI->load->database();

            $CI->db->where("original_image", $image_file);

            $sql = $CI->db->get("image_thumbs");
            $result = $sql->result();

            if(is_array($result) && !empty($result)) {
                foreach ($result as $row) {
                    #$thumb_ids[] = $row->id;

                    #delete physical file
                    unlink($thumb_path.$row->thumb);

                    #if file was deleted successfully ,then delete record in db
                    $CI->db->where("id", $row->id);
                    $CI->db->delete("image_thumbs");
                }
            }
        //echo $image_path."kuku";die();    
        #to finish of, delete the original file as well.    
        unlink($image_path);    
        }

    }

/* End of file image_helper.php */
/* Location: ./engine/helpers/image_helper.php */