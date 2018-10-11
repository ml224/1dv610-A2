# Login_1DV608
Interface repository for 1DV608 assignment 2 and 4

This app is using phpdotenv to store sensitive information as environment variables. 
https://github.com/vlucas/phpdotenv


### Added Uses-cases

## Use-case 1 - View Gallery
#### Main Scenario
1. User navigates to app
2. All gallery images are displayed
3. User authenticates (see [Authenticate User](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Course UseCases"))
4. All gallery images are displayed
5. User selects "My images"
6. Users images are displayed with option to delete 


## Use-case 2 - Upload Images
#### Main Scenario
1. User authenticates (see [Authenticate User](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md "Course UseCases"))
2. User selects "Upload Image"
    
3.  User selects a JPG/JPEG file from their computer that is less than 2MB
4. Image uploads successfully
5. Message is displayed
6. User reloads the page
7. No message is displayed
    
#### Alternative Scenario 1 - Invalid Size
3. User selects a file from their computer that is more than 2MB
4. Image is not uploaded

#### Alternative Scenario 2 - Invalid Type
3. Image is not JPG/JPEG
4. Image is not uploaded 

## Use-case 3 - Delete Images
