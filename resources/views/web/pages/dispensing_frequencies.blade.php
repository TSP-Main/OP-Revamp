@extends('web.layouts.default')
@section('title', 'Dispensing Frequencies')
@section('content')




<style>
    tbody {
        border: 1px solid black;
        width: 100%;
    }

    table {
        width: 100%;
    }

    td {
        border-bottom: 1px solid black;
    }

    th {
        background-color: #407ce7;
    }
</style>
<div class="ltn__utilize-overlay"></div>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area text-left bg-image " data-bs-bg="img/banner/Dispensing.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner">
                    <h1 class="page-title mt-5 text-black">Dispensing Frequencies</h1>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="/" class="text-black"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                            <li class="text-black">Dispensing Frequencies</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<div class="container">
    <h1>Dispensing Frequencies</h1>
    <p>As a responsible provider of prescription medications, Online Pharmacy 4U operate to strict dispensing volumes and frequencies.</p>
    <p>We are dedicated to safeguarding the public and ensuring that all prescriptions dispensed are appropriate, whilst minimising the risks associated with the medicines being supplied. Across all our working practices, Online Pharmacy 4U believes in transparency being a vital element to not only building trust, but also in upholding the regulations of pharmacy and the underlying principles that govern our respected profession.</p>
    <p>We have therefore made it clearer to our patients what standards we set as a pharmacy with respect to safeguarding their health, safety and wellbeing whilst ensuring that all supplies are clinically appropriate, timely and not excessive in quantity.</p>
    <div class="container">
        <table>
            <tbody class="text-center">
                <tr>
                    <td>
                        <p><strong>Medication</strong></p>
                    </td>
                    <td>
                        <p><strong>Maximum Supply </strong></p>
                    </td>
                    <td>
                        <p><strong>Time Interval Between Each Order</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Co-Codamol 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Co-Codamol 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">200</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Co-Dydramol 10/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Co-Dydramol 10/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">200</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Codeine Phosphate 15mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Codeine Phosphate 15mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Codeine Phosphate 30mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Codeine Phosphate 30mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Dihydrocodeine 30mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Dihydrocodeine 30mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">23 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Kapake 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Kapake 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">200</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Remedeine Forte 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">112</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Remedeine Forte 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">224</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Solpadol 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Solpadol 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">200</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 16.2mg/g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">88g (1 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">20 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 16.2mg/g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">176g (2 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">40 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 16.2mg/g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">264g (3 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">60 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 50mg/5g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">30 (1 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">20 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 50mg/5g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">60 (2 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">40 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Testogel 50mg/5g</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">90 (3 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">60 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Tostran 2%</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">60g (1 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">20 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Tostran 2%</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">120g (2 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">40 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Tostran 2%</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">180g (3 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">60 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Tostran 2%</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">240g (4 Pack)</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">80 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zapain 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">100</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zapain 30/500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">200</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zimovane 3.75mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zimovane 3.75mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zimovane 7.5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zimovane 7.5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zolpidem 5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zolpidem 5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zolpidem 10mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zolpidem 10mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zopiclone 3.75mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zopiclone 3.75mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zopiclone 7.5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">7</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Zopiclone 7.5mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">14</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Orlistat 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">42</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">13 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Orlistat 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">84</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Orlistat 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">168</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">54 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Orlistat 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">252</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">82 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Xenical 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">84</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">26 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Xenical 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">168</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">54 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Xenical 120mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">252</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">82 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Metformin 500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">24 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Metformin 500mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">112</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">52 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Metformin 850mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">24 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Metformin 850mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">112</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">52 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Ventolin 100mcg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">1 inhaler</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">38 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Ventolin 100mcg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">2 inhalers</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">76 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Ventolin 100mcg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">3 inhalers</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">114 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Finasteride 1mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">24 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Finasteride 1mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">52 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Finasteride 1mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">84</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">80 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Finasteride 1mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">168</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">164 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 25mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">24 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 25mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">52 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 25mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">84</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">80 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 50mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">28</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">24 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 50mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">56</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">52 days</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><span style="font-weight: 400;">Amitriptyline 50mg</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">84</span></p>
                    </td>
                    <td>
                        <p><span style="font-weight: 400;">80 days</span></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce