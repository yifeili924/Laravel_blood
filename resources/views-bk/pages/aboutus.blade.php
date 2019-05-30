@extends('layouts.main')
@section('content')
@include('partials.status-panel')
 <!-- banner-part-start-->
      <div class="inner_banner">
       <div class="container">
         <div class="about_sr">
           <h2>About<span>us</span></h2>
           
           <div class="pagination">
            <ul>
             <li><a href="{{ route('public.home') }}">Home</a></li>
             <li>About us</li>
            </ul>
           </div>
           
         </div>
       </div>
       
      </div>
    <!-- banner-part-end-->
    
    
    <div class="abot-part wp100 padding_bottom">
     <div class="container">
        <div class="area_part wp100">
          <p><img src="{{ asset('assets/images/aboimg.jpg') }}" alt="" class="right_img">Blood-Academy is a unique and interactive e-learning platform aimed at maximising your chances of passing the Fellowship of the Royal College of Pathologists (FRCPath) haematology exam. We are based in the UK and all content is provided by haematologists and scientists who have passed the exam.</p>
          <p>There is obviously no substitute to a well-structured training scheme. However, getting exposure to rare cases as well as developing and refining exam technique can be difficult. This site aims to develop these skills and help equip you to pass the exam and develop a passion for haematology that grows as an independent haematologist.</p>
          <p>Blood-Academy aims to be the most comprehensive revision resource available. We are constantly working in developing more content and because we are online we can be much more up-to-date than any written text. </p>
        </div>
        
        <div class="morphology wp100">
        <h2>Morphology</h2>
          <p>We have used innovative slide scanning technology to simulate the experience of viewing slides on a microscope. Using the Hamamatsu NanoZoomerscanner, it provides a number of exceptional features including smooth and quick navigation of slides, stepless zoom and accurate colour replication. Images can be zoomed in at x40 magnification and further zoomed using digitally to x80 magnification. This brings a range of cases to your screen forming the basis of your learning in morphology. </p>
          <p>With over 80 cases and over 300 questions, a vast range of topics are available. In addition to morphological diagnoses, you will be tested on the interpretation of other diagnostic techniques such as immunophenotyping, fluorescence in situ hybridisation, haemoglobin high performance liquid chromatography and gel electrophoresis. 
</p>
          <p>The cases mimic the style seen in the exam with clinical information and laboratory results forming the basis of a clinical diagnosis. In addition to the diagnostic challenges, supplementary questions on allied clinical issues such as treatment and prognosis are also presented. </p>
          <p>‘Model’ answers are provided in parallel to your answers to allow you to compare and identify areas of improvement. Detailed explanations that are specific to the issues highlighted and specific to the case are also provided. Explanations are focussed and give a wealth of additional opportunities learning opportunities. We have aimed to avoid lengthy and irrelevant information but use tables to summarise key points into bitesize nuggets. </p>
          
          <h4>Laboratory quality assurance</h4>
        </div>
        
        
     </div>
    </div>
		@stop