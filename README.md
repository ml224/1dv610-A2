# Login_1DV608
Interface repository for 1DV608 assignment 2 and 4

This app is using phpdotenv to store sensitive information as environment variables. Follow link for guidance of how to use phpdotenv.
https://github.com/vlucas/phpdotenv


### Added Uses-cases

## Use-case 1 - View Gallery
#### Main Scenario
(Not fully implemented - user can not choose their own images)
1. User navigates to app
2. All gallery images are displayed
3. User authenticates (see [Authenticate User](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Course UseCases"))
4. All gallery images are displayed
5. User selects "My images"
6. Users images are displayed with option to delete 


## Use-case 2 - Upload Images 
#### Main Scenario
(fully implemented, though usecase for resizing images would be desirable)
1. User authenticates (see [Authenticate User](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Course UseCases"))
2. User selects "Upload Image"  
3.  User selects a JPG/JPEG file from their computer that is less than 2MB
4. Image uploads successfully
5. Message is displayed with link back to gallery
6. User selects back to gallery
7. User is rerouted to main gallery page
    
#### Alternative Scenario 1 - Invalid Size
3. User selects a file from their computer that is more than 2MB
4. Image is not uploaded, helpful error message is rendered

#### Alternative Scenario 2 - Invalid Type
3. Image is not JPG/JPEG
4. Image is not uploaded, helpful error message is rendered

#### Alternative Scenario 2 - Invalid Type
3. User selects upload without choosing a file
4. Image is not uploaded, helpful error message is rendered 

## Use-case 3 - Delete Images

#### Main Scenario
(not implemented, user can delete any image)
1. User navigates to app
2. All gallery images are displayed
3. User authenticates (see [Authenticate User](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Course UseCases"))
4. Gallery images are displayed
6. User has option to delete the images uploaded by him/herself
7. User selects delete
8. Image is deleted
9. Success message and link back to gallery is displayed

### Test-cases

## Test-case 1.1 - View Gallery
Generic User
* Should not be able to delete images
* Should not be able to add images to gallery 

## Test-case 2.1 - Upload Image
### Input
* JPG/JPEG file
* Less than 2MB 

### Output
* rerouted to /?new_image=[file_name]
* success message displayed
* link back to gallery displayed
* uploaded image displayed

## Test-case 2.2 - Upload Image, wrong file type
### Input
* other than JPG 

### Output
* rerouted to /?error_message=Image_not_uploaded._Invalid_file_type._File_must_be_jpg/jpeg
* error message from url displayed
* link back to gallery displayed

## Test-case 2.3 - Upload Image, size > 2MB
### Input
* filesize > 2MB 

### Output
* rerouted to /?error_message=Image_not_uploaded._Invalid_size._Image_cannot_exceed_2MB
* error message from url displayed
* link back to gallery displayed


## Test-case 2.4 - Upload Image, no file chosen
### Input
* empty form

### Output
* rerouted to /?error_message=Image_not_uploaded._No_file_chosen,_image_not_uploaded
* error message from url displayed
* link back to gallery displayed


## Test-case 3.1 - Delete File
Users should only be able to delete their own files. Delete button should not be present on images that were uploaded by other users. This has not yet been implemented, users have the option to delete all images when logged in. 

### Input
* post-request with image id

### Output
* image deleted
* User rerouted to ?delete_image=[filename]
* message displayed: Image deleted successfully!
* link back to gallery presented

