<?php
function table_date($datetime)
{
    $date = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $datetime);
    if ($date instanceof DateTime) {
        return $date->format('M d, Y');
    } else {
        return 'Invalid datetime';
    }
}
function date_time_uk($datetime)
{

    $date= isset($datetime) ? date('d-m-y H:i:s', strtotime($datetime)) : '';
 
    if ($date) {
        return $date;
    } else {
        return 'Invalid datetime';
    }
}

function end_url()
{
    return url('/api') . '/';
}

function user_roles($role_no)
{
    switch ($role_no) {
        case 1:
            return 'Super Admin';
        case 2:
            return 'Dispensary';
        case 3:
            return 'Doctor';
        case 4:
            return 'User';
        default:
            return false;
    }
}

function auth_users()
{
    // status : 1 for active , 2 for pending, 3 for suspended , 4 for unverified ,5 for delete ...
    $user_status =  [1, 2];
    return $user_status;
}

function active_users()
{
    // status : 1 for active , 2 for pending, 3 for suspended , 4 for unverified ,5 for delete ...
    $user_status =  [1];
    return $user_status;
}

function user_role_no($role_no)
{
    switch ($role_no) {
        case 'Super Admin':
            return 1;
        case 'Dispensary':
            return 2;
        case 'Doctor':
            return 3;
        case 'User':
            return 4;
        default:
            return false;
    }
}

function view_permission($page_name)
{
    $user_role = auth()->user()->role;
    switch ($user_role) {

        case 'Super Admin':
            switch ($page_name) {
                case 'dashboard':
                case 'comment_store':
                case 'vet_prescription':
                case 'sops':
                case 'add_sop':
                case 'store_sop':
                case 'faq_questions':
                case 'gp_locations':
                case 'categories':
                case 'sub_categories':
                case 'child_categories':
                case 'dell_category':
                case 'add_category':
                case 'store_query':
                case 'company_details':
                case 'dell_question':
                case 'add_collection':
                case 'consultations':
                case 'questions':
                case 'add_question':
                case 'dispensary_approval':
                case 'assign_question':
                case 'prodcuts':
                case 'add_product':
                case 'orders':
                case 'admin.unpaidOrders':
                case 'consultation_view':
                case 'orders_shipped':
                case 'orders_unshiped':
                case 'orders_created':
                case 'orders_refunded':
                case 'orders_audit':
                case 'gpa_letters':
                case 'orders_recieved':
                case 'admin.allOrders';
                case 'doctors_approval':
                case 'doctors':
                case 'add_doctor':
                case 'dispensaries':
                case 'add_dispensary':
                case 'users':
                case 'contact':
                case 'setting':
                case 'faq':
                case 'featured_products':
                case 'question_categories':
                case 'add_question_category':
                case 'p_med_gq':
                case 'prescription_med_gq':
                    return true;
                default:
                    return false;
            }

        case 'Dispensary':
            switch ($page_name) {
                case 'dashboard':
                case 'gpa_letters':
                case 'orders_audit':
                case 'comment_store':
                case 'gp_locations':
                case 'orders':
                case 'sops':
                case 'store_query':
                case 'dispensary_approval':
                case 'doctors_approval':
                case 'orders_shipped':
                case 'orders_unshiped':
                case 'consultation_view':
                case 'contact':
                case 'setting':
                case 'faq':
                    return true;
                default:
                    return false;
            }

        case 'Doctor':
            switch ($page_name) {
                case 'dashboard':
                case 'comment_store':
                case 'orders_shipped':    
                case 'sops':    
                case 'store_query':
                case 'orders':
                case 'gp_locations':
                case 'gpa_letters':
                case 'consultation_view':
                case 'doctors_approval':
                case 'contact':
                case 'setting':
                case 'faq':
                    return true;
                default:
                    return false;
            }

        case 'User':
            switch ($page_name) {
                case 'home':
                case 'dashboard':
                case 'store_query':
                case 'consultation_view':
                case 'prescription_orders':
                case 'online_clinic_orders':
                case 'shop_orders':
                case 'contact':
                case 'setting':
                    return true;
                default:
                    return false;
            }

        default:
            return false;
    }
}

function STATE_LIST()
{
    return [
        'LND' => 'London, City of',
        'ABE' => 'Aberdeen City',
        'ABD' => 'Aberdeenshire',
        'ANS' => 'Angus',
        'AGB' => 'Argyll and Bute',
        'CLK' => 'Clackmannanshire',
        'DGY' => 'Dumfries and Galloway',
        'DND' => 'Dundee City',
        'EAY' => 'East Ayrshire',
        'EDU' => 'East Dunbartonshire',
        'ELN' => 'East Lothian',
        'ERW' => 'East Renfrewshire',
        'EDH' => 'Edinburgh, City of',
        'ELS' => 'Eilean Siar',
        'FAL' => 'Falkirk',
        'FIF' => 'Fife',
        'GLG' => 'Glasgow City',
        'HLD' => 'Highland',
        'IVC' => 'Inverclyde',
        'MLN' => 'Midlothian',
        'MRY' => 'Moray',
        'NAY' => 'North Ayrshire',
        'NLK' => 'North Lanarkshire',
        'ORK' => 'Orkney Islands',
        'PKN' => 'Perth and Kinross',
        'RFW' => 'Renfrewshire',
        'SCB' => 'Scottish Borders',
        'ZET' => 'Shetland Islands',
        'SAY' => 'South Ayrshire',
        'SLK' => 'South Lanarkshire',
        'STG' => 'Stirling',
        'WDU' => 'West Dunbartonshire',
        'WLN' => 'West Lothian',
        'ANN' => 'Antrim and Newtownabbey',
        'AND' => 'Ards and North Down',
        'ABC' => 'Armagh City, Banbridge and Craigavon',
        'BFS' => 'Belfast City',
        'CCG' => 'Causeway Coast and Glens',
        'DRS' => 'Derry and Strabane',
        'FMO' => 'Fermanagh and Omagh',
        'LBC' => 'Lisburn and Castlereagh',
        'MEA' => 'Mid and East Antrim',
        'MUL' => 'Mid-Ulster',
        'NMD' => 'Newry, Mourne and Down',
        'BDG' => 'Barking and Dagenham',
        'BNE' => 'Barnet',
        'BEX' => 'Bexley',
        'BEN' => 'Brent',
        'BRY' => 'Bromley',
        'CMD' => 'Camden',
        'CRY' => 'Croydon',
        'EAL' => 'Ealing',
        'ENF' => 'Enfield',
        'GRE' => 'Greenwich',
        'HCK' => 'Hackney',
        'HMF' => 'Hammersmith and Fulham',
        'HRY' => 'Haringey',
        'HRW' => 'Harrow',
        'HAV' => 'Havering',
        'HIL' => 'Hillingdon',
        'HNS' => 'Hounslow',
        'ISL' => 'Islington',
        'KEC' => 'Kensington and Chelsea',
        'KTT' => 'Kingston upon Thames',
        'LBH' => 'Lambeth',
        'LEW' => 'Lewisham',
        'MRT' => 'Merton',
        'NWM' => 'Newham',
        'RDB' => 'Redbridge',
        'RIC' => 'Richmond upon Thames',
        'SWK' => 'Southwark',
        'STN' => 'Sutton',
        'TWH' => 'Tower Hamlets',
        'WFT' => 'Waltham Forest',
        'WND' => 'Wandsworth',
        'WSM' => 'Westminster',
        'BNS' => 'Barnsley',
        'BIR' => 'Birmingham',
        'BOL' => 'Bolton',
        'BRD' => 'Bradford',
        'BUR' => 'Bury',
        'CLD' => 'Calderdale',
        'COV' => 'Coventry',
        'DNC' => 'Doncaster',
        'DUD' => 'Dudley',
        'GAT' => 'Gateshead',
        'KIR' => 'Kirklees',
        'KWL' => 'Knowsley',
        'LDS' => 'Leeds',
        'LIV' => 'Liverpool',
        'MAN' => 'Manchester',
        'NET' => 'Newcastle upon Tyne',
        'NTY' => 'North Tyneside',
        'OLD' => 'Oldham',
        'RCH' => 'Rochdale',
        'ROT' => 'Rotherham',
        'SLF' => 'Salford',
        'SAW' => 'Sandwell',
        'SFT' => 'Sefton',
        'SHF' => 'Sheffield',
        'SOL' => 'Solihull',
        'STY' => 'South Tyneside',
        'SHN' => 'St. Helens',
        'SKP' => 'Stockport',
        'SND' => 'Sunderland',
        'TAM' => 'Tameside',
        'TRF' => 'Trafford',
        'WKF' => 'Wakefield',
        'WLL' => 'Walsall',
        'WGN' => 'Wigan',
        'WRL' => 'Wirral',
        'WLV' => 'Wolverhampton',
        'BKM' => 'Buckinghamshire',
        'CAM' => 'Cambridgeshire',
        'CMA' => 'Cumbria',
        'DBY' => 'Derbyshire',
        'DEV' => 'Devon',
        'DOR' => 'Dorset',
        'ESX' => 'East Sussex',
        'ESS' => 'Essex',
        'GLS' => 'Gloucestershire',
        'HAM' => 'Hampshire',
        'HRT' => 'Hertfordshire',
        'KEN' => 'Kent',
        'LAN' => 'Lancashire',
        'LEC' => 'Leicestershire',
        'LIN' => 'Lincolnshire',
        'NFK' => 'Norfolk',
        'NYK' => 'North Yorkshire',
        'NTH' => 'Northamptonshire',
        'NTT' => 'Nottinghamshire',
        'OXF' => 'Oxfordshire',
        'SOM' => 'Somerset',
        'STS' => 'Staffordshire',
        'SFK' => 'Suffolk',
        'SRY' => 'Surrey',
        'WAR' => 'Warwickshire',
        'WSX' => 'West Sussex',
        'WOR' => 'Worcestershire',
        'BAS' => 'Bath and North East Somerset',
        'BDF' => 'Bedford',
        'BBD' => 'Blackburn with Darwen',
        'BPL' => 'Blackpool',
        'BGW' => 'Blaenau Gwent',
        'BCP' => 'Bournemouth, Christchurch and Poole',
        'BRC' => 'Bracknell Forest',
        'BGE' => 'Bridgend [Pen-y-bont ar Ogwr GB-POG]',
        'BNH' => 'Brighton and Hove',
        'BST' => 'Bristol, City of',
        'CAY' => 'Caerphilly [Caerffili GB-CAF]',
        'CRF' => 'Cardiff [Caerdydd GB-CRD]',
        'CMN' => 'Carmarthenshire [Sir Gaerfyrddin GB-GFY]',
        'CBF' => 'Central Bedfordshire',
        'CGN' => 'Ceredigion [Sir Ceredigion]',
        'CHE' => 'Cheshire East',
        'CHW' => 'Cheshire West and Chester',
        'CWY' => 'Conwy',
        'CON' => 'Cornwall',
        'DAL' => 'Darlington',
        'DEN' => 'Denbighshire [Sir Ddinbych GB-DDB]',
        'DER' => 'Derby',
        'DUR' => 'Durham, County',
        'ERY' => 'East Riding of Yorkshire',
        'FLN' => 'Flintshire [Sir y Fflint GB-FFL]',
        'GWN' => 'Gwynedd',
        'HAL' => 'Halton',
        'HPL' => 'Hartlepool',
        'HEF' => 'Herefordshire',
        'AGY' => 'Isle of Anglesey [Sir Ynys Môn GB-YNM]',
        'IOW' => 'Isle of Wight',
        'IOS' => 'Isles of Scilly',
        'KHL' => 'Kingston upon Hull',
        'LCE' => 'Leicester',
        'LUT' => 'Luton',
        'MDW' => 'Medway',
        'MTY' => 'Merthyr Tydfil [Merthyr Tudful GB-MTU]',
        'MDB' => 'Middlesbrough',
        'MIK' => 'Milton Keynes',
        'MON' => 'Monmouthshire [Sir Fynwy GB-FYN]',
        'NTL' => 'Neath Port Talbot [Castell-nedd Port Talbot GB-CTL]',
        'NWP' => 'Newport [Casnewydd GB-CNW]',
        'NEL' => 'North East Lincolnshire',
        'NLN' => 'North Lincolnshire',
        'NSM' => 'North Somerset',
        'NBL' => 'Northumberland',
        'NGM' => 'Nottingham',
        'PEM' => 'Pembrokeshire [Sir Benfro GB-BNF]',
        'PTE' => 'Peterborough',
        'PLY' => 'Plymouth',
        'POR' => 'Portsmouth',
        'POW' => 'Powys',
        'RDG' => 'Reading',
        'RCC' => 'Redcar and Cleveland',
        'RCT' => 'Rhondda Cynon Taff [Rhondda CynonTaf]',
        'RUT' => 'Rutland',
        'SHR' => 'Shropshire',
        'SLG' => 'Slough',
        'SGC' => 'South Gloucestershire',
        'STH' => 'Southampton',
        'SOS' => 'Southend-on-Sea',
        'STT' => 'Stockton-on-Tees',
        'STE' => 'Stoke-on-Trent',
        'SWA' => 'Swansea [Abertawe GB-ATA]',
        'SWD' => 'Swindon',
        'TFW' => 'Telford and Wrekin',
        'THR' => 'Thurrock',
        'TOB' => 'Torbay',
        'TOF' => 'Torfaen [Tor-faen]',
        'VGL' => 'Vale of Glamorgan, The [Bro Morgannwg GB-BMG]',
        'WRT' => 'Warrington',
        'WBK' => 'West Berkshire',
        'WIL' => 'Wiltshire',
        'WNM' => 'Windsor and Maidenhead',
        'WOK' => 'Wokingham',
        'WRX' => 'Wrexham [Wrecsam GB-WRC]',
        'YOR' => 'York',
    ];
}
