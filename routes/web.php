<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

$s = 'public.';
if (env('APP_ENV') != 'localhost') {
    URL::forceScheme('https');
//    error_reporting(0);
}

Route::get('/',         ['as' => $s . 'home',   'uses' => 'PagesController@getHome']);
Route::get('/home',         ['as' => $s . 'home',   'uses' => 'PagesController@getHome']);
Route::get('/aboutus', ['as' => $s . 'aboutus', 'uses' => 'PagesController@getAboutus']);
Route::get('/blogs', ['as' => $s . 'blogs', 'uses' => 'PagesController@getBlogs']);
Route::get('/blog/{id}', ['as' => $s . 'blog', 'uses' => 'PagesController@detailBlog']);
Route::get('/terms-use', ['as' => $s . 'terms-use', 'uses' => 'PagesController@getTermsuse']);
Route::get('/cookies-policy', ['as' => $s . 'cookies-policy', 'uses' => 'PagesController@getCookiePolicy']);
Route::get('/contact-us', ['as' => $s . 'contact-us', 'uses' => 'PagesController@getContactus']);
Route::post('/contact', ['as' => $s . 'contact', 'uses' => 'PagesController@contact']);
Route::post('/contact-page', ['as' => $s . 'contact-page', 'uses' => 'PagesController@contactPage']);
Route::get('/getusername', ['as' => $s . 'getusername', 'uses' => 'PagesController@getUsername']);
Route::post('/resetusername', ['as' => $s . 'contact', 'uses' => 'PagesController@resetUsername']);
Route::get('/explore-page', ['as' => $s . 'explore-page', 'uses' => 'PagesController@ExplorePage']);
Route::post('/checkque', ['as' => $s . 'checkque', 'uses' => 'UserController@checkQuestion']);
Route::post('/save-note', ['as' => $s . 'save-note', 'uses' => 'UserController@saveNote']);
Route::get('/pricing', ['as' => $s . 'pricing', 'uses' => 'PagesController@pricingPage']);
Route::get('/samples', ['as' => $s . 'samples', 'uses' => 'PagesController@samples']);
Route::get('/payment', ['as' => $s . 'payment', 'uses' => 'UserController@getPaymentPage']);
Route::get('/sample-mcq-emq', ['as' => $s . 'sample-mcq-emq', 'uses' => 'UserController@getSampleMcqs']);
Route::get('/sample-mcq-emq2', ['as' => $s . 'sample-mcq-emq2', 'uses' => 'UserController@getSampleMcqs2']);
Route::get('/sample-mcq-emq3', ['as' => $s . 'sample-mcq-emq3', 'uses' => 'UserController@getSampleMcqs3']);
Route::get('/sample-transfusion', ['as' => $s . 'sample-transfusion', 'uses' => 'UserController@getSampleTransfusion']);
Route::get('/sample-morphology', ['as' => $s . 'sample-morphology', 'uses' => 'UserController@getSampleMorphology']);
Route::get('/intcase', ['as' => $s . 'intcase', 'uses' => 'UserController@getIcasePagePublic']);

Route::post('/add-comment', ['as' =>'add_comment', 'uses' => 'CommentController@addComment']);
Route::post('/reply-comment', ['as' => 'reply', 'uses' => 'CommentController@replyComment']);
Route::post('/add-comment-morphology', ['as' =>'add_comment_to_morphology', 'uses' => 'CommentController@addCommentToMorphology']);
Route::post('/reply-morph', ['as' => 'reply_morph', 'uses' => 'CommentController@replyMorphComment']);

Route::post('/add-comment-figure', ['as' =>'add_comment_to_figure', 'uses' => 'CommentController@addCommentToFigure']);
Route::post('/reply-figure', ['as' => 'reply_figure', 'uses' => 'CommentController@replyFigureComment']);

Route::post('/add-comment-guidline', ['as' =>'add_comment_to_guidline', 'uses' => 'CommentController@addCommentToGuidline']);
Route::post('/reply-guidline', ['as' => 'reply_guidline', 'uses' => 'CommentController@replyGuidlineComment']);

$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\SocialController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\SocialController@getSocialHandle']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:administrator'], function()
{
    $a = 'admin.';
    Route::get('/blog', ['as' => $a . 'blog', 'uses' => 'BlogController@getBlog']);
    Route::get('/add_blog', ['as' => $a . 'add_bolg', 'uses' => 'BlogController@addBlog']);
    Route::post('/add-blog', ['as' => $a . 'add-blog', 'uses' => 'BlogController@postBlog']);
    Route::get('/blog-detail/{id}', ['as' => $a . 'blog_detail', 'uses' => 'BlogController@detailBlog']);
    Route::get('/blog_delete/{id}', ['as' => $a . 'blog_delete', 'uses' => 'BlogController@deleteBlog']);
    Route::get('/edit_blog/{id}', ['as' => $a . 'edit_blog', 'uses' => 'BlogController@editBlog']);
    Route::post('/update-blog', ['as' => $a . 'update-blog', 'uses' => 'BlogController@updateBlog']);

    Route::get('/', ['as' => $a . 'home', 'uses' => 'AdminController@getHome']);
    Route::get('/disImages', ['as' => $a . 'disImages', 'uses' => 'AdminController@disImages']);
    Route::get('/disSlides', ['as' => $a . 'disSlides', 'uses' => 'AdminController@disSlides']);
    Route::get('/members/{type}', ['as' => $a . 'members', 'uses' => 'AdminController@getMembers']);
    Route::get('/figurehub', ['as' => $a . 'figurehub', 'uses' => 'AdminController@getFigureHub']);
    Route::get('/slidehub', ['as' => $a . 'slidehub', 'uses' => 'AdminController@getSlideHub']);
    Route::get('/tests/{uid}', ['as' => $a . 'tests', 'uses' => 'AdminController@getTests']);
    Route::get('/edit-user/{user_id}', ['as' => $a . 'edit-user', 'uses' => 'AdminController@editMember']);
    Route::post('/update-member', ['as' => $a . 'update-member', 'uses' => 'AdminController@updateMember']);
    Route::post('/update-subs', ['as' => $a . 'update-subs', 'uses' => 'AdminController@updateSubscription']);
    Route::get('/add-user', ['as' => $a . 'add-user', 'uses' => 'AdminController@addMember']);
    Route::post('/add-member', ['as' => $a . 'add-member', 'uses' => 'AdminController@saveMember']);
    Route::get('/end-subs/{id}', ['as' => $a . 'end-subs', 'uses' => 'AdminController@cancelSubscription']);
    Route::get('/delete-user/{user_id}', ['as' => $a . 'delete-user', 'uses' => 'AdminController@deleteMember']);

    Route::get('/add-test', ['as' => $a . 'add-test', 'uses' => 'AdminController@addTest']);
    Route::post('/recent-updates', ['as' => $a . 'recent-updates', 'uses' => 'AdminController@recentUpdates']);
    Route::get('/pages', ['as' => $a . 'pages', 'uses' => 'AdminController@pages']);
    Route::post('/update-pages', ['as' => $a . 'update-pages', 'uses' => 'AdminController@updatePages']);

    Route::get('/delete-updates/{rid}', ['as' => $a . 'delete-updates', 'uses' => 'AdminController@deleteUpdates']);

    Route::get('/pay-history', ['as' => $a . 'pay-history', 'uses' => 'AdminController@payHistory']);
    Route::post('/filter-payment', ['as' => $a . 'filter-payment', 'uses' => 'AdminController@filterPayment']);

    Route::get('/info', ['as' => $a . 'info', 'uses' => 'AdminController@addInfo']);
    Route::get('/guidelines', ['as' => $a . 'guidelines', 'uses' => 'AdminController@guidelines']);
    Route::post('/update-info', ['as' => $a . 'update-info', 'uses' => 'AdminController@updateInfo']);

    // Preview
    Route::get('/mcq-preview', ['as' => $a . 'mcq-preview', 'uses' => 'AdminController@mcqPreview']);
    Route::get('/next-preview-mcq/{index}', ['as' => $a . 'next-preview-mcq', 'uses' => 'AdminController@mcqPreview']);

    // Add test view
    Route::get('exam/mcq-emq', ['as' => $a . 'mcq-emq', 'uses' => 'AdminController@viewMcqEmq']);
    Route::get('exam/essay-questions', ['as' => $a . 'essay-questions', 'uses' => 'AdminController@viewEssayQuestions']);
    Route::get('exam/morphology', ['as' => $a . 'morphology', 'uses' => 'AdminController@viewMorphology']);
    Route::get('exam/quality-assurance', ['as' => $a . 'quality-assurance', 'uses' => 'AdminController@viewQualityAssurance']);
    Route::get('exam/transfusion', ['as' => $a . 'transfusion', 'uses' => 'AdminController@viewTransfusion']);
    Route::get('exam/haemothromb', ['as' => $a . 'haemothromb', 'uses' => 'AdminController@viewHaemoThromb']);

    // Add test save
    Route::post('/add-mcq-emq', ['as' => $a . 'add-mcq-emq', 'uses' => 'AdminController@addMcqEmq']);
    Route::get('exam/mcq-emq', ['as' => $a . 'mcq-emq', 'uses' => 'AdminController@viewMcqEmq']);
    Route::post('/add-essay-ques', ['as' => $a . 'add-essay-ques', 'uses' => 'AdminController@addEssayques']);
    Route::post('/add-morphology', ['as' => $a . 'add-morphology', 'uses' => 'AdminController@addMorphology']);
    Route::post('/add-quality-assurance', ['as' => $a . 'add-quality-assurance', 'uses' => 'AdminController@addQualityAssurance']);
    Route::post('/add-transfusion', ['as' => $a . 'add-transfusion', 'uses' => 'AdminController@addTransfusion']);
    Route::post('/add-guideline', ['as' => $a . 'add-guideline', 'uses' => 'AdminController@addGuideline']);
    Route::post('/add-haemo', ['as' => $a . 'add-haemo', 'uses' => 'AdminController@addHaemoThromb']);

    // Update
    Route::post('/update-essay-ques', ['as' => $a . 'update-essay-ques', 'uses' => 'AdminController@UpdateEssayques']);
    Route::post('/update-morphology', ['as' => $a . 'update-morphology', 'uses' => 'AdminController@updateMorphology']);
    Route::post('/update-quality-assurance', ['as' => $a . 'update-quality-assurance', 'uses' => 'AdminController@updateQualityAssurance']);
    Route::post('/update-transfusion', ['as' => $a . 'update-transfusion', 'uses' => 'AdminController@updateTransfusion']);
    Route::post('/update-haemothromb', ['as' => $a . 'update-haemothromb', 'uses' => 'AdminController@updateHaemoThromb']);
    Route::post('/update-mcq-emq', ['as' => $a . 'update-mcq-emq', 'uses' => 'AdminController@updateMcqEmq']);
    Route::post('/addfigure', ['as' => $a . 'addfigure', 'uses' => 'AdminController@addFigure']);
    Route::post('/resetFigure', ['as' => $a . 'resetFigure', 'uses' => 'AdminController@resetFigure']);
    Route::post('/addslide', ['as' => $a . 'addslide', 'uses' => 'AdminController@addSlide']);
    Route::post('/resetcase', ['as' => $a . 'resetcase', 'uses' => 'AdminController@resetCase']);

    // Delete
    Route::get('/delete-question-mcq/{r_id}', ['as' => $a . 'delete-question-mcq', 'uses' => 'AdminController@deleteQuestionmcq']);
    Route::get('/delete-question-essay/{r_id}', ['as' => $a . 'delete-question-essay', 'uses' => 'AdminController@deleteQuestionEssay']);
    Route::get('/delete-question-morphology/{r_id}', ['as' => $a . 'delete-question-morphology', 'uses' => 'AdminController@deleteQuestionMorphology']);
    Route::get('/delete-quality-assurance/{r_id}', ['as' => $a . 'delete-quality-assurance', 'uses' => 'AdminController@deleteQuestionQualityAssurance']);
    Route::get('/delete-transfusion/{r_id}', ['as' => $a . 'delete-transfusion', 'uses' => 'AdminController@deleteQuestionTransfusion']);
    Route::get('/delete-haemothromb/{r_id}', ['as' => $a . 'delete-haemothromb', 'uses' => 'AdminController@deleteQuestionHaemothromb']);
    Route::get('/delete-guideline/{r_id}', ['as' => $a . 'delete-guideline', 'uses' => 'AdminController@deleteGuideline']);


    // Edit
    Route::get('/edit-question-mcq/{r_id}', ['as' => $a . 'edit-question-mcq', 'uses' => 'AdminController@editQuestionMcq']);

    Route::get('/preview-question-mcq/{r_id}', ['as' => $a . 'preview-question-mcq', 'uses' => 'AdminController@previewQuestionMcq']);

    Route::get('/edit-question-essay/{r_id}', ['as' => $a . 'edit-question-essay', 'uses' => 'AdminController@editQuestionEssay']);
    Route::get('/edit-question-morphology/{r_id}', ['as' => $a . 'edit-question-morphology', 'uses' => 'AdminController@editQuestionMorphology']);
    Route::get('/edit-question-quality-assurance/{r_id}', ['as' => $a . 'edit-quality-assurance', 'uses' => 'AdminController@editQualityAssurance']);
    Route::get('/edit-question-transfusion/{r_id}', ['as' => $a . 'edit-transfusion', 'uses' => 'AdminController@editTransfusion']);
    Route::get('/edit-question-haemothromb/{r_id}', ['as' => $a . 'edit-haemothromb', 'uses' => 'AdminController@editHaemoThromb']);
    Route::get('/edit-question-guideline/{r_id}', ['as' => $a . 'edit-guideline', 'uses' => 'AdminController@editGuideline']);
    // preview
    Route::get('/preview-question-mcq/{r_id}', ['as' => $a . 'preview-question-mcq', 'uses' => 'AdminController@previewQuestionMcq']);
    Route::get('/preview-question-essay/{r_id}', ['as' => $a . 'preview-question-essay', 'uses' => 'AdminController@previewQuestionEssay']);
    Route::get('/preview-question-morphology/{r_id}', ['as' => $a . 'preview-question-morphology', 'uses' => 'AdminController@previewQuestionMorphology']);
    Route::get('/preview-question-quality/{r_id}', ['as' => $a . 'preview-question-quality', 'uses' => 'AdminController@previewQuestionQuality']);
    Route::get('/preview-question-transfusion/{r_id}', ['as' => $a . 'preview-question-transfusion', 'uses' => 'AdminController@previewQuestionTransfusion']);
    Route::get('/preview-guideline/{r_id}', ['as' => $a . 'preview-guideline', 'uses' => 'AdminController@previewGuidleline']);
    Route::get('/preview-question-haemothromb/{r_id}', ['as' => $a . 'preview-question-haemothromb', 'uses' => 'AdminController@previewQuestionHaemothromb']);

    // fix db
    Route::get('/morphology/migrateMorphology', ['as' => $a . 'migrateMorphology', 'uses' => 'AdminController@migrateMorphology']);
    Route::get('/dbfix', ['as' => $a . 'dbfix', 'uses' => 'AdminController@fixDb']);
    Route::get('/fixchoiceIndecies', ['as' => $a . 'fixchoiceIndecies', 'uses' => 'AdminController@fixchoiceIndecies']);
    Route::get('/view-comments', ['as' => $a . 'view-comments', 'uses' => 'AdminController@viewComments']);
    Route::get('/getComments', ['as' => $a . 'getComments', 'uses' => 'AdminController@getComments']);
    Route::get('/shownewslidesapi', ['as' => $a . 'shownewslidesapi', 'uses' => 'AdminController@getAllSlides']);

    Route::post('/annotation/add', ['as' => $a . 'addAnnotation', 'uses' => 'AdminController@addAnnotation']);
    Route::get('/annotation/get/{slideId}', ['as' => $a . 'getAnnotation', 'uses' => 'AdminController@getAnnotations']);
    Route::post('/annotation/remove', ['as' => $a . 'removeAnnotation', 'uses' => 'AdminController@deleteAnnotation']);
    Route::get('/manageslides', ['as' => $a . 'manageslides', 'uses' => 'AdminController@manageSlides']);
    Route::get('/importslides/{bucket_name}', ['as' => $a . 'importslides', 'uses' => 'AdminController@importSlides']);
    Route::get('/slide/get/{slide_id}', ['as' => $a . 'getslide', 'uses' => 'AdminController@getSlide']);
    Route::get('/slide/getbyname/{slide_name}', ['as' => $a . 'getSlide', 'uses' => 'AdminController@showSlideByName']);
    Route::get('/managecases', ['as' => $a . 'managecases', 'uses' => 'AdminController@manageCases']);
    Route::get('/cases/get/all', ['as' => $a . 'getallcases', 'uses' => 'AdminController@getAllCases']);
    Route::post('/cases/add', ['as' => $a . 'addcases', 'uses' => 'AdminController@addCases']);
    Route::post('/cases/remove', ['as' => $a . 'removecase', 'uses' => 'AdminController@removeCase']);
    Route::get('/cases/import/{file_name}', ['as' => $a . 'importcase', 'uses' => 'AdminController@importCases']);
    Route::get('/cases/removewhitespaces', ['as' => $a . 'removewhitespaces', 'uses' => 'AdminController@removeWhiteSpaces']);

    Route::get('/managesampletype', ['as' => $a . 'managesampletype', 'uses' => 'AdminController@manageSampleType']);
    Route::get('/sample/get/all', ['as' => $a . 'getAllSamples', 'uses' => 'AdminController@getAllSamples']);
    Route::post('/sample/add', ['as' => $a . 'addSample', 'uses' => 'AdminController@addSample']);
    Route::post('/sample/remove', ['as' => $a . 'removeSample', 'uses' => 'AdminController@removeSample']);
    Route::post('/figures/import', ['as' => $a . 'figuresImport', 'uses' => 'AdminController@importFigure']);
    Route::post('/figures/importfrombucket', ['as' => $a . 'importfrombucket', 'uses' => 'AdminController@importFigureFromBucket']);
    Route::get('/morphology/fixslidextensions', ['as' => $a . 'fixslidextensions', 'uses' => 'AdminController@fixSlideExtensions']);

    Route::get('/icase', ['as' => $a . 'icase', 'uses' => 'AdminController@icase']);
    Route::post('/icase/add', ['as' => $a . 'addicase', 'uses' => 'AdminController@addICase']);
    Route::get('/icase/getall', ['as' => $a . 'getall', 'uses' => 'AdminController@getallicases']);
    Route::get('/icase/delete/{icaseid}', ['as' => $a . 'deleteicase', 'uses' => 'AdminController@deleteIcase']);
    Route::post('/icase/importfeatures', ['as' => $a . 'figuresFeatures', 'uses' => 'AdminController@importFeatures']);

});

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function()
{
    $a = 'user.';
    Route::get('/blogs', ['as' => $a . 'blogs', 'uses' => 'UserController@getBlogs']);
    Route::get('/blog-detail/{id}', ['as' => $a . 'blog_detail', 'uses' => 'UserController@detailBlog']);
    Route::get('/view-comments/{id}', ['as' => $a . 'replies', 'uses' => 'CommentController@viewComments']);


    Route::get('/', ['as' => $a . 'home', 'uses' => 'UserController@getHome']);
    Route::get('/subscribe', ['as' => $a . 'subscribe', 'uses' => 'UserController@getSubscribeForm']);
    Route::get('/payments', ['as' => $a . 'payments', 'uses' => 'UserController@getPayments']);
    Route::post('/get-mcq-ques', ['as' => $a . 'get-mcq-ques', 'uses' => 'UserController@getMcqQues']);
    Route::post('/mcq-ques-page', ['as' => $a . 'mcq-ques-page', 'uses' => 'UserController@McqQuesPage']);
    Route::post('/essay-ques-page', ['as' => $a . 'essay-ques-page', 'uses' => 'UserController@EssayQuesPage']);
    Route::post('/stripe-payment', ['as' => $a . 'stripe-payment', 'uses' => 'UserController@stripePayment']);
    Route::get('/get-coupon', ['as' => $a . 'get-coupon', 'uses' => 'UserController@getCoupon']);
    Route::get('/verify', ['as' => $a . 'verify', 'uses' => 'UserController@verifyAccount']);

    Route::post('/get-essay-ques', ['as' => $a . 'get-essay-ques', 'uses' => 'UserController@getEssayQues']);
    Route::post('/get-morphology-ques', ['as' => $a . 'get-morphology-ques', 'uses' => 'UserController@getMorphologyQues']);

    Route::post('/morphology-ques-page', ['as' => $a . 'morphology-ques-page', 'uses' => 'UserController@MorphologyQuesPage']);
    Route::post('/morphology-ques-page-next', ['as' => $a . 'morphology-ques-page-next', 'uses' => 'UserController@MorphologyQuesNextPage']);

    Route::post('/get-quality-assurance-ques', ['as' => $a . 'get-quality-assurance-ques', 'uses' => 'UserController@getQualityAssuranceQues']);
    Route::post('/quality-assurance-page', ['as' => $a . 'quality-assurance-page', 'uses' => 'UserController@QualityAssuranceQuesPage']);

    Route::post('/get-transfusion-ques', ['as' => $a . 'get-transfusion-ques', 'uses' => 'UserController@TransfusionQuesPage']);
    Route::post('/get-haemothromb-ques', ['as' => $a . 'get-haemothromb-ques', 'uses' => 'UserController@HaemothrombQuesPage']);
    Route::post('/transfusion-page', ['as' => $a . 'transfusion-page', 'uses' => 'UserController@TransfusionQues']);
    Route::post('/haemothromb-page', ['as' => $a . 'haemothromb-page', 'uses' => 'UserController@HaemothrombQues']);
    Route::post('/transfusion-page-next', ['as' => $a . 'transfusion-page-next', 'uses' => 'UserController@TransfusionQuesNextPage']);

    Route::get('/edit-profile', ['as' => $a . 'edit-profile', 'uses' => 'UserController@editProfilePage']);
    Route::post('/update-user', ['as' => $a . 'update-user', 'uses' => 'UserController@updateUser']);
    Route::post('/update-user-pass', ['as' => $a . 'update-user-pass', 'uses' => 'UserController@updateUserPass']);

    Route::get('/invoice-page/{pid}', ['as' => $a . 'invoice-page', 'uses' => 'UserController@invoicePage']);

    Route::get('/figures/{fid}', ['as' => $a . 'figurepage', 'uses' => 'UserController@figurePage']);
    Route::get('/guidelinesummaries/{fid}', ['as' => $a . 'guidelinesummaries', 'uses' => 'UserController@guidlinePage']);
    Route::get('/slide/{sname}/{stype}/{cid}', ['as' => $a . 'slidepage', 'uses' => 'UserController@slidePage']);
    Route::get('/reset-stats', ['as' => $a . 'reset-stats', 'uses' => 'UserController@resetStats']);
    Route::get('/reviewinc', ['as' => $a . 'reviewinc', 'uses' => 'UserController@reviewIncorrect']);
    Route::get('/reviewall', ['as' => $a . 'reviewall', 'uses' => 'UserController@reviewAll']);

    Route::get('/getMorphology', ['as' => $a . 'getMorphology', 'uses' => 'UserController@getMorphology']);
    Route::get('/getquestion/{qtype}/{qid}', ['as' => $a . 'getquestion', 'uses' => 'UserController@getQuestion']);
    Route::post('/submitcomment', ['as' => $a . 'submitcomment', 'uses' => 'UserController@submitComment']);

    Route::get('/slide/get/{slide_id}', ['as' => $a . 'getSlide', 'uses' => 'UserController@showSlide']);
    Route::get('/annotations/get/{slide_id}', ['as' => $a . 'getAnnotations', 'uses' => 'UserController@getAnnotations']);

    Route::get('/case/get/{case_id}/{sample_type}', ['as' => $a . 'getCase', 'uses' => 'UserController@showCase']);
    Route::get('/reviewsession', ['as' => $a . 'reviewsession', 'uses' => 'UserController@reviewSessionIncorrect']);


    Route::get('/icases/get/features', ['as' => $a . 'icasefeatures', 'uses' => 'UserController@getFeatures']);
    Route::get('/icases/get/useranswers/{caseId}', ['as' => $a . 'icaseuseranswers', 'uses' => 'UserController@getIcaseUserAnswers']);
    Route::post('/icase/answer/submit', ['as' => $a . 'icasesubmit', 'uses' => 'UserController@submitIcase']);
    Route::get('/icases/get/report/{caseId}', ['as' => $a . 'icasereport', 'uses' => 'UserController@getIcaseReport']);

    Route::group(['middleware' => 'activated'], function ()
    {
        $m = 'activated.';
        Route::get('protected', ['as' => $m . 'protected', 'uses' => 'UserController@getDashboard']);
    });

    Route::group(['middleware' => 'subscription'], function ()
    {
        $m = 'subscription.';
        Route::get('/analytics', ['as' => $m . 'analytics', 'uses' => 'UserController@getAnalytics']);
        Route::get('/mcq-emq-opt', ['as' => $m . 'exam-mcq-emq-opt', 'uses' => 'UserController@getMcqEmqOpt']);
        Route::get('/essay-questions', ['as' => $m . 'exam-essay-questions', 'uses' => 'UserController@getEssayOpt']);
        Route::get('/morphology', ['as' => $m . 'exam-morphology', 'uses' => 'UserController@getMorphologyOpt']);
        Route::get('/quality-assurance', ['as' => $m . 'exam-quality-assurance', 'uses' => 'UserController@getQualityAssuranceOpt']);
        Route::get('/transfusion', ['as' => $m . 'exam-transfusion', 'uses' => 'UserController@getTransfusionOpt']);
        Route::get('/haemothromb', ['as' => $m . 'exam-haemothromb', 'uses' => 'UserController@getHaemothrombOpt']);
//        Route::get('/hubfigures', ['as' => $m . 'hubfigures', 'uses' => 'UserController@getHubFigures']);
//        Route::get('/hubslides', ['as' => $m . 'hubslides', 'uses' => 'UserController@getHubSlides']);
//        Route::get('/guidelines', ['as' => $m . 'guidelines', 'uses' => 'UserController@getGuidlinesSummaries']);
//        Route::get('/interactive-modules', ['as' => $m . 'interactive-modules', 'uses' => 'UserController@getInteractiveModules']);
//        Route::get('/icases', ['as' => $m . 'icases', 'uses' => 'UserController@getIcases']);
//        Route::get('/icasepage/{icaseid}', ['as' => $m . 'icase', 'uses' => 'UserController@getIcasePage']);
//        Route::get('/icases/get/{icaseid}', ['as' => $m . 'icase', 'uses' => 'UserController@getIcase']);
    });

    Route::group(['middleware' => 'hubsub'], function ()
    {
        $m = 'subscription.';
        Route::get('/icases', ['as' => $m . 'icases', 'uses' => 'UserController@getIcases']);
        Route::get('/icasepage/{icaseid}', ['as' => $m . 'icase', 'uses' => 'UserController@getIcasePage']);
        Route::get('/icases/get/{icaseid}', ['as' => $m . 'icase', 'uses' => 'UserController@getIcase']);

        Route::get('/hubslides', ['as' => $m . 'hubslides', 'uses' => 'UserController@getHubSlides']);

        Route::get('/hubfigures', ['as' => $m . 'hubfigures', 'uses' => 'UserController@getHubFigures']);

        Route::get('/guidelines', ['as' => $m . 'guidelines', 'uses' => 'UserController@getGuidlinesSummaries']);

        Route::get('/interactive-modules', ['as' => $m . 'interactive-modules', 'uses' => 'UserController@getInteractiveModules']);

        Route::get('/gim/{modTitle}/{modFolder}/{moduleName}', ['as' => $m . 'gim', 'uses' => 'UserController@getModule']);
    });
});

Route::group(['middleware' => 'auth:all'], function()
{
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/activate/{token}', ['as' => $a . 'activate', 'uses' => 'ActivateController@activate']);
    Route::get('/activate', ['as' => $a . 'activation-resend', 'uses' => 'ActivateController@resend']);
    Route::get('not-activated', ['as' => 'not-activated', 'uses' => function () {
        return view('errors.not-activated');
    }]);
    Route::get('no-subscription', ['as' => 'no-subscription', 'uses' => function () {
        return view('errors.no-subscription');
    }]);
});

Auth::routes(['login' => 'auth.login']);

// test route for firebase
Route::get('fb','FirebaseController@index');