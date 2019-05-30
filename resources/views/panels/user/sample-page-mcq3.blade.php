@extends('layouts.sample')
@section('pageTitle', 'Multiple Choice & Extended Matching Questions')

@section('content')
    @include('partials.status-panel')

    <div class="container">
        <div class="subtitle">
            <span>EMQ</span>
            <span>Question 3 of 3 </span>
        </div>

        <div class="question">
            <p> A 33-year-old woman who is 12 weeks pregnant attends her booking appointment.
                This is her third pregnancy; other than a post-partum haemorrhage of >2500ml due
                to placenta previa, she had no major complications in any of her previous pregnancies.
                She has the same partner for this pregnancy that she had for her previous two pregnancies.
                She has no significant personal or family medical history and is not taking any regular medication.
                The results of some of her investigations are as follows:
            </p>
            <br/>
            <p>
                <table style="width:25%; font-size: 15px; font-weight: 900">
                    <tr>
                        <td><p>Haemoglobin</p></td>
            <td><p>103 g/l</p></td>
            </tr>
            <tr>
                <td><p>MCV</p></td>
                <td><p>84fl</p></td>
            </tr>
            <tr>
                <td><p>White cell count</p></td>
                <td><p>8.9 x 10<sup>9</sup>/l</p></td>
            </tr>
            <tr>
                <td><p>Platelets</p></td>
                <td><p>114 x 10<sup>9</sup>/l</p></td>
            </tr>
            <tr>
                <td><p>Clauss fibrinogen</p></td>
                <td><p>2.5 g/l</p></td>
            </tr>
            <tr>
                <td><p>Ferritin</p></td>
                <td><p>102 ug/l</p></td>
            </tr>
            <tr>
                <td><p>Creatinine</p></td>
                <td><p>64 mmol/l</p></td>
            </tr>
            </table>
            </p>
            <br />
            <p>
                What further action from the list below should be offered to her at this stage of the pregnancy?
            </p>
            <p>
                Please select ONE of the following options:
            </p>
        </div>

        <div class="question-menu-caption shadow">Questions</div>
        <div class="row no-padding">
            <div class="mcq-questions">
                <div class="question-list">
                    <div class="content-row flexDiv">
                        <div class="row-char">
                            <b>	A </b>
                        </div>
                        <div>
                            <p>A 24-year-old man presents with sudden onset headache.
                                A CT scan with contrast shows a triangular filling defect (empty delta sign).
                                A blood film shows polychromasia. Other investigations show a serum ferritin of 22 and an MCV of 101fl.
                            </p>
                        </div>
                    </div>
                    <div class="content-row flexDiv">
                        <div style="margin-right: 50px">
                            <span id="span1">Answer</span>
                        </div>
                        <div style="width: 80%">
                            <select onchange='selectans()' name='select1' id='select1' style="width: 100%">
                                <option value='INCORRECT'>Choose from one of the following answers</option>
                                <option value='INCORRECT'>Serum folate</option>
                                <option value='INCORRECT'>Serum vitamin B12 level</option>
                                <option value='INCORRECT'>Direct antiglobulin test</option>
                                <option value='INCORRECT'>Bone marrow aspirate</option>
                                <option value='INCORRECT'>Serum protein electrophoresis</option>
                                <option value='INCORRECT'>Serum ferritin</option>
                                <option value='INCORRECT'>Transferrin saturation</option>
                                <option value='INCORRECT'>Serum homocysteine</option>
                                <option value='INCORRECT'>Serum free light chain ratio</option>
                                <option value='CORRECT'>Peripheral blood immunophenotyping</option>
                            </select>
                            <span class="ans" id="ansselect1"></span>
                        </div>
                    </div>

                    <div class="content-row flexDiv">
                        <div class="row-char">
                            <b> B </b>
                        </div>
                        <div>
                            <p>A 78-year-old man presents with chronic fatigue and breathlessness. He has a macrocytic anaemia
                                (haemoglobin 98 g/l, MCV 112fl) but normal haematinic levels and bilirubin. The blood film shows red
                                cell anisopoikilocytosis, polychromasia, some pseudo Pelger-Huet neutrophils, and the occasional
                                nucleated red cell.
                            </p>
                        </div>
                    </div>
                    <div class="content-row flexDiv">
                        <div style="margin-right: 50px">
                            <span id="span2">Answer</span>
                        </div>
                        <div style="width: 80%">
                            <select onchange='selectans()' name='select2' id='select2' style="width: 100%">
                                <option value='INCORRECT'>Choose from one of the following answers</option>
                                <option value='INCORRECT'>Serum folate</option>
                                <option value='INCORRECT'>Serum vitamin B12 level</option>
                                <option value='INCORRECT'>Direct antiglobulin test</option>
                                <option value='CORRECT'>Bone marrow aspirate</option>
                                <option value='INCORRECT'>Serum protein electrophoresis</option>
                                <option value='INCORRECT'>Serum ferritin</option>
                                <option value='INCORRECT'>Transferrin saturation</option>
                                <option value='INCORRECT'>Serum homocysteine</option>
                                <option value='INCORRECT'>Serum free light chain ratio</option>
                                <option value='INCORRECT'>Peripheral blood immunophenotyping</option>
                            </select>
                            <span class="ans" id="ansselect2"></span>
                        </div>
                    </div>

                    <div class="content-row flexDiv">
                        <div class="row-char">
                            <b>	C </b>
                        </div>
                        <div>
                            <p>A 19-year-old woman presents with chronic fatigue. A blood film shows polychromasia,
                                microcytosis, hypochromia, elliptocytes, and pencil cells.
                            </p>
                        </div>
                    </div>
                    <div class="content-row flexDiv">
                        <div style="margin-right: 50px">
                            <span id="span3">Answer</span>
                        </div>
                        <div style="width: 80%">
                            <select onchange='selectans()' name='select3' id='select3' style="width: 100%">
                                <option value='INCORRECT'>Choose from one of the following answers</option>
                                <option value='INCORRECT'>Serum folate</option>
                                <option value='INCORRECT'>Serum vitamin B12 level</option>
                                <option value='INCORRECT'>Direct antiglobulin test</option>
                                <option value='INCORRECT'>Bone marrow aspirate</option>
                                <option value='INCORRECT'>Serum protein electrophoresis</option>
                                <option value='CORRECT'>Serum ferritin</option>
                                <option value='INCORRECT'>Transferrin saturation</option>
                                <option value='INCORRECT'>Serum homocysteine</option>
                                <option value='INCORRECT'>Serum free light chain ratio</option>
                                <option value='INCORRECT'>Peripheral blood immunophenotyping</option>
                            </select>
                            <span class="ans" id="ansselect3"></span>
                        </div>
                    </div>

                    <div class="content-row flexDiv">
                        <div class="row-char">
                            <b>	D </b>
                        </div>
                        <div>
                            <p>An 82-year-old woman presents with weight loss, fatigue, and macrocytosis (121fl).
                                Other investigations show a raised lactate dehydrogenase and mildly elevated bilirubin.
                                A blood film shows background staining, no polychromasia, some hypersegmented neutrophils,
                                and an occasional large erythroblast.
                            </p>
                        </div>
                    </div>
                    <div class="content-row flexDiv">
                        <div style="margin-right: 50px">
                            <span id="span4">Answer</span>
                        </div>
                        <div style="width: 80%">
                            <select onchange='selectans()'name='select4' id='select4' style="width: 100%">
                                <option value='INCORRECT'>Choose from one of the following answers</option>
                                <option value='INCORRECT'>Serum folate</option>
                                <option value='CORRECT'>Serum vitamin B12 level</option>
                                <option value='INCORRECT'>Direct antiglobulin test</option>
                                <option value='INCORRECT'>Bone marrow aspirate</option>
                                <option value='INCORRECT'>Serum protein electrophoresis</option>
                                <option value='INCORRECT'>Serum ferritin</option>
                                <option value='INCORRECT'>Transferrin saturation</option>
                                <option value='INCORRECT'>Serum homocysteine</option>
                                <option value='INCORRECT'>Serum free light chain ratio</option>
                                <option value='INCORRECT'>Peripheral blood immunophenotyping</option>
                            </select>
                            <span class="ans" id="ansselect4"></span>
                        </div>
                    </div>

                    <div class="content-row flexDiv">
                        <div class="row-char">
                            <b>	E </b>
                        </div>
                        <div>
                            <p>An 89-year-old man presents with fatigue and normocytic anaemia
                                (haemoglobin 102 g/l, MCV 89fl). A blood film shows polychromasia, rouleaux,
                                and background staining. His renal function is normal.
                            </p>
                        </div>
                    </div>
                    <div class="content-row flexDiv">
                        <div style="margin-right: 50px">
                            <span id="span5">Answer</span>
                        </div>
                        <div style="width: 80%">
                            <select onchange='selectans()' name='select5' id='select5' style="width: 100%">
                                <option value='INCORRECT'>Choose from one of the following answers</option>
                                <option value='INCORRECT'>Serum folate</option>
                                <option value='INCORRECT'>Serum vitamin B12 level</option>
                                <option value='INCORRECT'>Direct antiglobulin test</option>
                                <option value='INCORRECT'>Bone marrow aspirate</option>
                                <option value='INCORRECT'>Serum protein electrophoresis</option>
                                <option value='INCORRECT'>Serum ferritin</option>
                                <option value='INCORRECT'>Transferrin saturation</option>
                                <option value='INCORRECT'>Serum homocysteine</option>
                                <option value='INCORRECT'>Serum free light chain ratio</option>
                                <option value='CORRECT'>Peripheral blood immunophenotyping</option>
                            </select>
                            <span class="ans" id="ansselect5"></span>
                        </div>
                    </div>
                </div>

                <div class="menu_box" id="discussion-box" style="display: none;">
                    <h3 class="menu_title shadow alter">Discussion</h3>
                    <ul class="ref">
                        <p>
                            1. ANSWER: Peripheral blood immunophenotyping. A diagnosis of paroxysmal
                            nocturnal haematuria should be suspected in this patient.
                            The patient has evidence of a cerebral venous sinus thrombosis.
                            The delta sign seen in the CT scan is typical of a dural venous sinus
                            thrombosis of the superior sagittal sinus. Polychromasia, iron deficiency,
                            and macrocytosis suggests chronic intravascular haemolysis.
                            Immunophenotyping of the blood should be requested to look for the absence of
                            GPI-linked markers (see: [link]) inducing uncontrolled complement-mediated damage.
                        </p>
                        <br />
                        <p>
                            2. ANSWER: Bone marrow aspirate. The age of the patient and the dysplastic
                            features in the blood film suggest a diagnosis of myelodysplastic syndrome.
                            A bone marrow examination to analyse dysplastic features in progenitor cells
                            and assess the blast percentage is needed. Cytogenetic analysis should also be
                            undertaken to help assign a prognostic score (e.g. IPSS, R-IPSS).
                        </p>
                        <br />
                        <p>
                            3. ANSWER: Serum ferritin. The patient’s blood film describes the classical
                            features of iron deficiency. A serum ferritin would confirm the diagnosis.
                            The age and sex of the patient suggests a gynaecological cause.
                            If a gynaecological cause is not found, gastrointestinal investigations
                            (e.g. coeliac screen, endoscopy) should be considered.
                        </p>
                        <br />
                        <p>
                            4. ANSWER: Serum vitamin B12 level. The patient’s investigations,
                            especially her blood film, point towards a diagnosis of megaloblastic anaemia.
                            The most common cause is vitamin B12 deficiency and so the vitamin B12 levels should be measured.
                            A folic acid level measurement should also be requested but recent ingestion of highly folate-rich
                            foods (e.g. fortified cereals) may skew results and so testing can be unreliable.
                            If the vitamin B12 level is normal, more specialist investigations
                            (e.g. homocysteine, methylmalonic acid, and holotranscobalamin level measurements)
                            can be undertaken to confirm the diagnosis of vitamin B12 deficiency.
                        </p>
                        <br />
                        <p>
                            5. ANSWER: Serum protein electrophoresis. Rouleaux and background staining suggest
                            an increase in immunoglobulins and so investigations with serum protein electrophoresis
                            to detect the presence of a paraprotein should be requested next. Light chain myeloma
                            is less likely because his renal function is normal, although a serum free light chain
                            assay and urinary Bence Jones protein testing should also be undertaken.
                        </p>
                    </ul>
                </div>


                <div class="row no-padding">
                    <button class="link-primary" type="button" name="submit" id="current" disabled="" style="float: left; margin-right: 15px; margin-top: 0" onclick="showans()">Submit &nbsp;<i class="fa fa-angle-double-right"></i></button>
                    <a href="{{route('public.samples')}}" class="link-primary" name="next" id="next" style="float: left; margin-right: 15px" >Back to sample questions &nbsp;<i class="fa fa-angle-double-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectans(event) {
            document.getElementById("current").removeAttribute("disabled");
        }
        function showans(event) {
            $('#correct').addClass('correct');
            $('#discussion-box').css("display", "block");
            $('#current').css('display', 'none');

            doStuff("#select1", "#ansselect1", "#span1");
            doStuff("#select2", "#ansselect2", "#span2");
            doStuff("#select3", "#ansselect3", "#span3");
            doStuff("#select4", "#ansselect4", "#span4");
            doStuff("#select5", "#ansselect5", "#span5");

        }

        function doStuff(selector, answer, spanny) {
            var conceptName = $(selector + " option").filter(":selected").val();
            if (conceptName === 'CORRECT') {
                $(selector).parent().parent().css('color', 'green');
                $(spanny).text('CORRECT');
            } else {
                $(selector).parent().parent().css('color', 'red');
                $(spanny).text('INCORRECT');
            }
        }
    </script>
@stop