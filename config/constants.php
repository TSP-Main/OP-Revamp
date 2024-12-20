<?php
// config\constants.php
return [

    'USER_STATUS' => [
        'Active'     => 1,
        'Pending'    => 2,
        'Suspend'    => 3,
        'Unverified' => 4,
        'Deleted'     => 5
    ],

    'STATUS' => [
        'Active' => 1,
        'Deactive' => 2,
        'Deleted' => 3
    ],

    'P_MED_GENERAL_QUESTIONS' => [
        [
            'id' => 1,
            'title' => 'Who will use this medicine?',
            'desc' => '',
            'order' => '1',
        ],
        [
            'id' => 2,
            'title' => 'Will the user(s) of this medicine be:',
            'desc' => '',
            'order' => '2',
        ],
        [
            'id' => 3,
            'title' => 'What is the age of the person who is going to be taking this medication ?',
            'desc' => '',
            'order' => '3',
        ],
        [
            'id' => 4,
            'title' => 'What will this medicine be used for?',
            'desc' => '',
            'order' => '4',
        ],
        [
            'id' => 5,
            'title' => 'How long have the symptoms been present?',
            'desc' => '',
            'order' => '5',
        ],

        [
            'id' => 6,
            'title' => 'Have any medicine been already taken to treat these symptoms?',
            'desc' => '',
            'order' => '6',
        ],
        [
            'id' => 7,
            'title' => 'Additional Details of symptoms',
            'desc' => '',
            'order' => '7',
        ],

        [
            'id' => 8,
            'title' => 'Does the person who will use this medicine have any medical conditions?',
            'desc' => '',
            'order' => '8',
        ],
        [
            'id' => 9,
            'title' => 'Additional Details of medical conditions',
            'desc' => '',
            'order' => '9',
        ],
        [
            'id' => 10,
            'title' => 'Is the person who will use this medicine currently taking any medication?',
            'desc' => '',
            'order' => '10',
        ],        [
            'id' => 11,
            'title' => 'Do you have any questions or concerns about this medicine that you would like to make the pharmacy team aware of?',
            'desc' => '',
            'order' => '11',
        ],        [
            'id' => 12,
            'title' => 'Have you read the information on the product page and will you read the Patient Information Leafiet before taking the medicine?',
            'desc' => '',
            'order' => '12',
        ],        [
            'id' => 13,
            'title' => 'This medicine should only be used for short term relief.If your symptoms persist you should  consult your GP.By confirming below, you are stating that you understand this medicine is for short term use only.',
            'desc' => '',
            'order' => '13',
        ],
        [
            'id' => 14,
            'title' => 'You agree that you have not placed multiple orders recently of this item',
            'desc' => '',
            'order' => '14',
        ]
    ],

    'PRESCRIPTION_MED_GENERAL_QUESTIONS' => [
        [
            'id' => 1,
            'title' => 'Are you registered with a GP practice in the UK?',
            'desc' => '',
            'order' => '1',
        ],
        [
            'id' => 2,
            'title' => 'Why are you not registered with a GP practice?',
            'desc' => '',
            'order' => '2',
        ],
        [
            'id' => 3,
            'title' => 'Do you give us consent to write to your GP to share information of the supply & information we hold about you?',
            'desc' => '',
            'order' => '3',
        ],
        [
            'id' => 4,
            'title' => 'Please enter the name of your GP practice.',
            'desc' => '',
            'order' => '4',
        ],
        [
            'id' => 5,
            'title' => 'Do you believe you have the capacity to make decisions about your own healthcare?',
            'desc' => '',
            'order' => '5',
        ],
        [
            'id' => 6,
            'title' => 'Have you been diagnosed with any medical conditions?',
            'desc' => '',
            'order' => '6',
        ],
        [
            'id' => 7,
            'title' => 'Please provide more information, including diagnosis, symptoms and treatment.',
            'desc' => '',
            'order' => '7',
        ],
        [
            'id' => 8,
            'title' => 'Have you ever been diagnosed with a mental health condition?',
            'desc' => '',
            'order' => '8',
        ],
        [
            'id' => 9,
            'title' => 'Please provide more information, including diagnosis, symptoms and treatment?',
            'desc' => '',
            'order' => '9',
        ],
        [
            'id' => 10,
            'title' => 'Are you currently taking any medication? This includes prescription-only, over-the-counter and homeopathic medicines.',
            'desc' => '',
            'order' => '10',
        ],
        [
            'id' => 11,
            'title' => 'Which medication, what strength and how often are you taking it?',
            'desc' => '',
            'order' => '11',
        ],
        [
            'id' => 12,
            'title' => 'Do you suffer from any allergies?',
            'desc' => '',
            'order' => '12',
        ],
        [
            'id' => 13,
            'title' => 'What allergies do you have and what are the symptoms you experience from an allergic reaction?',
            'desc' => '',
            'order' => '13',
        ],
        [
            'id' => 14,
            'title' => 'Is there anything else you would like to include for the prescriber?',
            'desc' => '',
            'order' => '14',
        ],
        [
            'id' => 15,
            'title' => 'Please provide further information:',
            'desc' => '',
            'order' => '15',
        ],
        [
            'id' => 16,
            'title' => 'What is your height?',
            'desc' => '',
            'order' => '16',
        ],
        [
            'id' => 17,
            'title' => 'What is your weight?',
            'desc' => '',
            'order' => '17',
        ],
        [
            'id' => 18,
            'title' => 'Full Name (Legal Name):',
            'desc' => '',
            'order' => '18',
        ],
        [
            'id' => 19,
            'title' => 'Date of Birth (DD/MM/YYYY):',
            'desc' => '',
            'order' => '19',
        ],
    ],

    'PRODUCT_TEMPLATES' => [
        1 => 'Pharmacy Medicine(P.Med)',      // second prioeiry(pmd)
        2 => 'Prescription Medicine(POM)',   // high priority (premd)
        3 => 'Over the Counter Medicines'   // thired
    ],

    'PHARMACY_MEDECINE' => 1,
    'PRESCRIPTION_MEDICINE' => 2,
    'COUNTER_MEDICINE' => 3,


     'ukCities' => [
        "London", "Birmingham", "Manchester", "Liverpool", "Glasgow", "Newcastle", "Sheffield", "Leeds",
        "Bristol",
        "Edinburgh", "Leicester", "Coventry", "Bradford", "Cardiff", "Belfast", "Nottingham",
        "Kingston upon Hull",
        "Plymouth", "Southampton", "Reading", "Aberdeen", "Portsmouth", "York", "Swansea",
        "Milton Keynes", "Derby",
        "Stoke-on-Trent", "Northampton", "Luton", "Wolverhampton", "Wigan", "Norwich", "Chester",
        "Cambridge",
        "Oxford", "Dundee", "Inverness", "Exeter", "Swindon", "Derry", "Lisburn", "Newry", "Armagh",
        "Londonderry", "Bangor", "Craigavon", "Ballymena", "Newtownabbey", "Coleraine", "Limavady",
        "Ballyclare",
        "Cookstown", "Strabane", "Holywood", "Warrenpoint", "Larne", "Banbridge", "Donaghadee",
        "Downpatrick",
        "Carrickfergus", "Portadown", "Lurgan", "Portrush", "Comber", "Ballymoney", "Crumlin",
        "Maghera",
        "Whitehead", "Enniskillen", "Dungannon", "Randalstown", "Moira", "Dromore", "Saintfield",
        "Kilkeel",
        "Ballycastle", "Rathfriland", "Killyleagh", "Crossgar", "Strangford", "Cullybackey", "Keady",
        "Bushmills",
        "Cushendall", "Greenisland", "Rostrevor", "Portaferry", "Glenavy", "Bessbrook", "Portstewart",
        "Clogher",
        "Donaghcloney", "Blackrock", "Belleek", "Castlederg", "Coalisland", "Carnlough", "Clough",
        "Waringstown",
        "Magherafelt", "Glenarm", "Loughbrickland", "Greyabbey", "Broughshane", "Ballyronan",
        "Millisle", "Gilford",
        "Ballygowan", "Castlewellan", "Portglenone", "Aughnacloy", "Gortin", "Eglinton", "Sion Mills",
        "Ballycarry",
        "Castlederg", "Ederney", "Irvinestown", "Ballinderry", "Macosquin", "Donaghmore", "Aghagallon",
        "Kilrea",
        "Ballygawley", "Portballintrae", "Cloughmills", "Cushendun", "Ballykelly", "Dunloy", "Aghalee",
        "Moneymore",
        "Tandragee", "Belleek", "Moy", "Garvagh", "Newtownhamilton", "Loughgall", "Lisnaskea",
        "Lisbellaw",
        "Ballinamallard", "Derrygonnelly", "Belcoo", "Antrim", "Crumlin", "Draperstown", "Dundrum",
        "Portaferry",
        "Comber", "Newtownards", "Saintfield", "Bangor", "Portaferry", "Dungiven", "Ederney", "Fintona",
        "Kesh",
        "Lisnaskea", "Macosquin", "Maghera", "Moneymore", "Portglenone", "Ballynure", "Greenisland",
        "Newtownabbey",
        "Holywood", "Ballynahinch", "Newcastle", "Annalong", "Hillsborough", "Moira", "Waringstown",
        "Richhill",
        "Keady", "Tandragee", "Markethill", "Cullybackey", "Broughshane", "Ahoghill", "Portglenone",
        "Cushendall",
        "Waterfoot", "Cullybackey", "Glenavy", "Crumlin", "Ballynure", "Greenisland", "Newtownabbey",
        "Holywood",
        "Ballynahinch", "Newcastle", "Annalong", "Hillsborough", "Moira", "Waringstown", "Richhill",
        "Keady",
        "Tandragee", "Markethill", "Cullybackey", "Broughshane", "Ahoghill", "Newtownards", "Portrush",
        "Rathlin Island",
        "Coleraine", "Castlerock", "Limavady", "Ballykelly", "Dungiven", "Maghera", "Kilrea",
        "Bushmills", "Portstewart",
        "Ballymoney", "Ballintoy", "Cushendun", "Carnlough", "Glenarm", "Larne", "Ballygally",
        "Islandmagee",
        "Whitehead", "Carrickfergus", "Newtownabbey", "Greenisland", "Antrim", "Crumlin", "Randalstown",
        "Ballyclare",
        "Larne", "Magherafelt", "Coagh", "Tamlaght", "Bellaghy", "Portglenone", "Glenarm", "Carnlough",
        "Ballymena",
        "Larne", "Ballyclare", "Randalstown", "Crumlin", "Antrim", "Ballymoney", "Coleraine",
        "Portstewart",
        "Portrush", "Limavady", "Dungiven", "Maghera", "Castledawson", "Toomebridge", "Moneymore",
        "Magherafelt",
        "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore", "Magherafelt", "Cookstown", "Coagh",
        "Tamlaght",
        "Bellaghy", "Portglenone", "Magherafelt", "Toomebridge", "Ballyronan", "Maghera", "Ballymena",
        "Ballymoney",
        "Bushmills", "Portstewart", "Portrush", "Limavady", "Dungiven", "Maghera", "Castledawson",
        "Toomebridge",
        "Moneymore", "Magherafelt", "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore",
        "Magherafelt",
        "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore", "Magherafelt", "Cookstown", "Coagh",
        "Tamlaght",
        "Bellaghy", "Portglenone", "Magherafelt", "Toomebridge", "Ballyronan", "Maghera", "Ballymena",
        "Ballymoney",
        "Bushmills", "Portstewart", "Portrush", "Limavady", "Dungiven", "Maghera", "Castledawson",
        "Toomebridge",
        "Moneymore", "Magherafelt", "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore",
        "Magherafelt",
        "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore", "Magherafelt", "Cookstown", "Coagh",
        "Tamlaght",
        "Bellaghy", "Portglenone", "Magherafelt", "Toomebridge", "Ballyronan", "Maghera", "Ballymena",
        "Ballymoney",
        "Bushmills", "Portstewart", "Portrush", "Limavady", "Dungiven", "Maghera", "Castledawson",
        "Toomebridge",
        "Moneymore", "Magherafelt", "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore",
        "Magherafelt",
        "Cookstown", "Coagh", "Tamlaght", "Bellaghy", "Moneymore", "Magherafelt", "Cookstown", "Coagh",
        "Tamlaght",
        "Bellaghy", "Portglenone", "Magherafelt", "Toomebridge", "Ballyronan", "Maghera", "Ballymena",
        "Ballymoney",
        "Bushmills", "Portstewart", "Portrush", "Limavady", "Dungiven", "Maghera", "Castledawson",
        "Toomebridge",
        "Moneymore", "Magherafelt", "Cookstown", "Coagh", "Tamlaght"
     ],

     'ukPostalcode' => [
        "AB10 1XG", "AB11 5QN", "AB12 3CD", "AB15 6YZ", "AB16 5EF", // Aberdeen
        "B1 1AA", "B1 2AB", "B2 3CD", "B4 5EF", "B5 6YZ", // Birmingham
        "BH1 1AA", "BH2 2AB", "BH3 3CD", "BH4 5EF", "BH5 6YZ", // Bournemouth
        "BS1 1AA", "BS2 2AB", "BS3 3CD", "BS4 5EF", "BS5 6YZ", // Bristol
        "CA1 1AA", "CA2 2AB", "CA3 3CD", "CA4 5EF", "CA5 6YZ", // Carlisle
        "CH1 1AA", "CH2 2AB", "CH3 3CD", "CH4 5EF", "CH5 6YZ", // Chester
        "CV1 1AA", "CV2 2AB", "CV3 3CD", "CV4 5EF", "CV5 6YZ", // Coventry
        "CR0 1AA", "CR2 2AB", "CR4 3CD", "CR7 5EF", "CR8 6YZ", // Croydon
        "DY1 1AA", "DY2 2AB", "DY4 3CD", "DY5 5EF", "DY8 6YZ", // Dudley
        "DA1 1AA", "DA2 2AB", "DA5 3CD", "DA7 5EF", "DA8 6YZ", // Dartford
        "DH1 1AA", "DH2 2AB", "DH3 3CD", "DH4 5EF", "DH5 6YZ", // Durham
        "EH1 1AA", "EH2 2AB", "EH3 3CD", "EH4 5EF", "EH5 6YZ", // Edinburgh
        "EN1 1AA", "EN2 2AB", "EN3 3CD", "EN4 5EF", "EN5 6YZ", // Enfield
        "FY1 1AA", "FY2 2AB", "FY4 3CD", "FY5 5EF", "FY6 6YZ", // Blackpool (FY)
        "GL1 1AA", "GL2 2AB", "GL3 3CD", "GL4 5EF", "GL5 6YZ", // Gloucester
        "G1 1AA", "G2 2AB", "G3 3CD", "G4 5EF", "G5 6YZ", // Glasgow
        "GU1 1AA", "GU2 2AB", "GU3 3CD", "GU4 5EF", "GU5 6YZ", // Guildford
        "HA0 1AA", "HA1 2AB", "HA2 3CD", "HA3 5EF", "HA4 6YZ", // Harrow
        "HD1 1AA", "HD2 2AB", "HD3 3CD", "HD4 5EF", "HD5 6YZ", // Huddersfield
        "IP1 1AA", "IP2 2AB", "IP3 3CD", "IP4 5EF", "IP5 6YZ", // Ipswich
        "KA1 1AA", "KA2 2AB", "KA3 3CD", "KA4 5EF", "KA5 6YZ", // Kilmarnock
        "KT1 1AA", "KT2 2AB", "KT3 3CD", "KT4 5EF", "KT5 6YZ", // Kingston upon Thames
        "L1 1AA", "L2 2AB", "L3 3CD", "L4 5EF", "L5 6YZ", // Liverpool
        "LE1 1AA", "LE2 2AB", "LE3 3CD", "LE4 5EF", "LE5 6YZ", // Leicester
        "LN1 1AA", "LN2 2AB", "LN3 3CD", "LN4 5EF", "LN5 6YZ", // Lincoln
        "LS1 1AA", "LS2 2AB", "LS3 3CD", "LS4 5EF", "LS5 6YZ", // Leeds
        "LU1 1AA", "LU2 2AB", "LU3 3CD", "LU4 5EF", "LU5 6YZ", // Luton
        "M1 1AA", "M2 2AB", "M3 3CD", "M4 5EF", "M5 6YZ", // Manchester
        "ME1 1AA", "ME2 2AB", "ME3 3CD", "ME4 5EF", "ME5 6YZ", // Medway
        "NE1 1AA", "NE2 2AB", "NE3 3CD", "NE4 5EF", "NE5 6YZ", // Newcastle upon Tyne
        "NG1 1AA", "NG2 2AB", "NG3 3CD", "NG4 5EF", "NG5 6YZ", // Nottingham
        "NP1 1AA", "NP2 2AB", "NP3 3CD", "NP4 5EF", "NP5 6YZ", // Newport
        "NR1 1AA", "NR2 2AB", "NR3 3CD", "NR4 5EF", "NR5 6YZ", // Norwich
        "OL1 1AA", "OL2 2AB", "OL3 3CD", "OL4 5EF", "OL5 6YZ", // Oldham
        "OX1 1AA", "OX2 2AB", "OX3 3CD", "OX4 5EF", "OX5 6YZ", // Oxford
        "PE1 1AA", "PE2 2AB", "PE3 3CD", "PE4 5EF", "PE5 6YZ", // Peterborough
        "PO1 1AA", "PO2 2AB", "PO3 3CD", "PO4 5EF", "PO5 6YZ", // Portsmouth
        "RG1 1AA", "RG2 2AB", "RG3 3CD", "RG4 5EF", "RG5 6YZ", // Reading
        "RH1 1AA", "RH2 2AB", "RH3 3CD", "RH4 5EF", "RH5 6YZ", // Redhill
        "S1 1AA", "S2 2AB", "S3 3CD", "S4 5EF", "S5 6YZ", // Sheffield
        "SM1 1AA", "SM2 2AB", "SM3 3CD", "SM4 5EF", "SM5 6YZ", // Sutton
        "SO14 1AA", "SO15 2AB", "SO16 3CD", "SO17 5EF", "SO18 6YZ", // Southampton
        "SP1 1AA", "SP2 2AB", "SP3 3CD", "SP4 5EF", "SP5 6YZ", // Salisbury
        "ST1 1AA", "ST2 2AB", "ST3 3CD", "ST4 5EF", "ST5 6YZ", // Stoke-on-Trent
        "SW1A 1AA", "SW1B 2AB", "SW1C 3CD", "SW1D 5EF", "SW1E 6YZ", // London (Westminster)
        "TN1 1AA", "TN2 2AB", "TN3 3CD", "TN4 5EF", "TN5 6YZ", // Tunbridge Wells
        "TS1 1AA", "TS2 2AB", "TS3 3CD", "TS4 5EF", "TS5 6YZ", // Teesside
        "TW1 1AA", "TW2 2AB", "TW3 3CD", "TW4 5EF", "TW5 6YZ", // Twickenham
        "WA1 1AA", "WA2 2AB", "WA3 3CD", "WA4 5EF", "WA5 6YZ", // Warrington
        "WF1 1AA", "WF2 2AB", "WF3 3CD", "WF4 5EF", "WF5 6YZ", // Wakefield
     ],
     'ukAddress' =>  [
        '10 Downing Street, London',
        '221B Baker Street, London',
        'Buckingham Palace, London',
        'Westminster Abbey, London',
        'Tower of London, London',
        'Trafalgar Square, London',
        'The Shard, London',
        'London Eye, London',
        'Natural History Museum, London',
        'Piccadilly Circus, London',
        'Hyde Park, London',
        'Edinburgh Castle, Edinburgh',
        'Royal Mile, Edinburgh',
        'Arthur\'s Seat, Edinburgh',
        'Glasgow Cathedral, Glasgow',
        'Kelvingrove Art Gallery and Museum, Glasgow',
        'Titanic Belfast, Belfast',
        'Giants Causeway, Bushmills',
        'Cardiff Castle, Cardiff',
        'Principality Stadium, Cardiff',
        'Snowdon, Llanberis',
        'Bath Abbey, Bath',
        'Roman Baths, Bath',
        'Stonehenge, Amesbury',
        'Windsor Castle, Windsor',
        'Stratford-upon-Avon, Warwickshire',
        'Canterbury Cathedral, Canterbury',
        'Brighton Pier, Brighton',
        'The Needles, Isle of Wight',
        'Chatsworth House, Bakewell',
        'Lake District National Park, Cumbria',
        'York Minster, York',
        'Eden Project, Cornwall',
        'St. Ives, Cornwall',
        'Durham Cathedral, Durham',
        'Hadrian\'s Wall, Northumberland',
        'Liverpool Cathedral, Liverpool',
        'The Beatles Story, Liverpool',
        'Old Trafford, Manchester',
        'Manchester Town Hall, Manchester',
        'Albert Dock, Liverpool',
        'Peak District National Park, Derbyshire',
        'Belfast City Hall, Belfast',
        'Royal Pavilion, Brighton',
        'Tower Bridge, London',
        'Kew Gardens, London',
        'St. Paul\'s Cathedral, London',
        'Oxford University, Oxford',
        'Cambridge University, Cambridge',
        'Salisbury Cathedral, Salisbury',
        'Dover Castle, Dover',
        'Liverpool Street Station, London',
        'Manchester Piccadilly Station, Manchester',
        'Leeds Castle, Kent',
        'The O2 Arena, London',
        'HMS Victory, Portsmouth',
        'Royal Observatory, Greenwich',
        'Royal Albert Hall, London',
        'The British Museum, London',
        'Royal Botanic Gardens, Kew',
        'Natural History Museum, London',
        'Victoria and Albert Museum, London',
        'British Library, London',
        'The Shard, London',
        'Tate Modern, London',
        'British Film Institute, London',
        'Houses of Parliament, London',
        'London Zoo, London',
        'Tower of London, London',
        'Westminster Abbey, London',
        'Tate Britain, London',
        'Imperial War Museum, London',
        'Science Museum, London',
        'National Gallery, London',
        'National Portrait Gallery, London',
        'Courtauld Gallery, London',
        'Somerset House, London',
        'Saatchi Gallery, London',
        'Victoria and Albert Museum, London',
        'Wimbledon, London',
        'Globe Theatre, London',
        'Regent\'s Park, London',
        'Hyde Park, London',
        'Green Park, London',
        'St James\'s Park, London',
        'Kensington Gardens, London',
        'Richmond Park, London',
        'Hampstead Heath, London',
        'Primrose Hill, London',
        'Greenwich Park, London',
        'Alexandra Palace, London',
        'Crystal Palace Park, London',
        'Hampton Court Palace, London',
        'Kew Palace, London',
        'Buckingham Palace, London',
        'Windsor Castle, Windsor',
        'Ham House, London',
        'Osterley Park, London',
        'Eltham Palace, London',
        'Hatfield House, Hatfield',
        'Knebworth House, Knebworth',
        'Hever Castle, Hever',
        'Leeds Castle, Leeds',
        'Chartwell, Westerham',
        'Penshurst Place, Penshurst',
        'Bodiam Castle, Robertsbridge',
        'Scotney Castle, Lamberhurst',
        'Sissinghurst Castle, Cranbrook',
        'Knole House, Sevenoaks',
        'Dover Castle, Dover',
        'Canterbury Cathedral, Canterbury',
        'Rochester Castle, Rochester',
        'Gothic Temple, Stowe Landscape Gardens, Buckingham',
        'Cliveden House, Taplow',
        'Waddesdon Manor, Aylesbury',
        'Hughenden Manor, High Wycombe',
        'West Wycombe Park, West Wycombe',
        'Blenheim Palace, Woodstock',
        'Chatsworth House, Bakewell',
        'Haddon Hall, Bakewell',
        'Hardwick Hall, Chesterfield',
        'Kedleston Hall, Derby',
        'Lyme Park, Stockport',
        'Tatton Park, Knutsford',
        'Little Moreton Hall, Congleton',
        'Nunnington Hall, York',
        'Rievaulx Abbey, Rievaulx',
        'Fountains Abbey, Ripon',
        'Castle Howard, York',
        'Bolsover Castle, Bolsover',
        'Burghley House, Stamford',
        'Belton House, Grantham',
        'Doddington Hall, Lincoln',
        'Gunby Hall, Spilsby',
        'Lacock Abbey, Lacock',
        'Salisbury Cathedral, Salisbury',
        'Stourhead, Warminster',
        'Wilton House, Salisbury',
        'Longleat, Warminster',
        'Montacute House, Montacute',
        'Tyntesfield, Wraxall',
        'Barrington Court, Barrington',
        'Dunster Castle, Dunster',
        'Knightshayes Court, Tiverton',
        'Arlington Court, Barnstaple',
        'Powderham Castle, Exeter',
        'Bradford on Avon, Bradford on Avon',
        'Clifton Suspension Bridge, Bristol',
        'Bristol Cathedral, Bristol',
        'Tyntesfield, Bristol',
        'SS Great Britain, Bristol',
        'Bath Abbey, Bath',
        'Roman Baths, Bath',
        'Prior Park Landscape Garden, Bath',
        'Cheddar Gorge, Cheddar',
        'Glastonbury Tor, Glastonbury',
        'Wells Cathedral, Wells',
        'Stourhead, Warminster',
        'Lytes Cary Manor, South Somerset',
        'Tintinhull Garden, Tintinhull',
        'Barrington Court, Ilminster',
        'Bridgwater, Bridgwater',
        'Castle Cary, Castle Cary',
        'Crewkerne, Crewkerne',
        'Chard, Chard',
        'Glastonbury, Glastonbury',
        'Ilminster, Ilminster',
        'Langport, Langport',
        'Minehead, Minehead',
        'Somerton, Somerton',
        'South Petherton, South Petherton',
        'Stoke-sub-Hamdon, Stoke-sub-Hamdon',
        'Street, Street',
        'Taunton, Taunton',
        'Watchet, Watchet',
        'Wellington, Wellington',
        'Wincanton, Wincanton',
        'Wiveliscombe, Wiveliscombe',
        'Yeovil, Yeovil',
        'Axbridge, Axbridge',
        'Burnham-on-Sea, Burnham-on-Sea',
        'Cheddar, Cheddar',
        'Clevedon, Clevedon',
        'Glastonbury, Glastonbury',
        'Highbridge, Highbridge',
        'Nailsea, Nailsea',
        'Portishead, Portishead',
        'Street, Street',
        'Weston-super-Mare, Weston-super-Mare',
        'Winscombe, Winscombe',
        'Worle, Worle',
        'Yatton, Yatton',
        'Radstock, Radstock',
        'Midsomer Norton, Midsomer Norton',
        'Peasedown St John, Peasedown St John',
        'Timsbury, Timsbury',
        'Clutton, Clutton',
        'Temple Cloud, Temple Cloud',
        'Farrington Gurney, Farrington Gurney',
        'Chew Valley, Chew Valley',
        'Paulton, Paulton',
        'Cameley, Cameley',
        'Mendip Hills, Mendip Hills',
        'Shepton Mallet, Shepton Mallet',
        'Wells, Wells',
        'Glastonbury, Glastonbury',
        'Street, Street',
        'Cheddar, Cheddar',
        'Radstock, Radstock',
        'Midsomer Norton, Midsomer Norton',
        'Frome, Frome',
        'Weston-super-Mare, Weston-super-Mare',
        'Burnham-on-Sea, Burnham-on-Sea',
        'St. Ives Harbour, St. Ives',
        'Minack Theatre, Porthcurno',
        'Tintagel Castle, Tintagel',
        'Pendennis Castle, Falmouth',
        'Fistral Beach, Newquay',
        'Land\'s End, Sennen',
        'Trebah Garden, Mawnan Smith',
        'The Eden Project, Par',
        'Porthminster Beach, St. Ives',
        'Port Isaac Harbour, Port Isaac',
        'Lost Gardens of Heligan, St. Austell',
        'Lizard Point, Lizard',
        'St. Mawes Castle, St. Mawes',
        'St. Agnes Head, St. Agnes',
        'Godrevy Lighthouse, Hayle',
        'Tate St Ives, St. Ives',
        'St. Nicholas Chapel, St. Ives',
        'St. Enodoc Church, Trebetherick',
        'Porthcurno Beach, Porthcurno',
        'Barbara Hepworth Museum and Sculpture Garden, St. Ives',
        'Padstow Harbour, Padstow',
        'Perranporth Beach, Perranporth',
        'Bodmin Moor, Bodmin',
        'Bude Sea Pool, Bude',
        'Blue Reef Aquarium, Newquay',
        'Newquay Zoo, Newquay',
        'Porthcurno Telegraph Museum, Porthcurno',
        'St. Petroc\'s Church, Bodmin',
        'Lappa Valley Steam Railway, Newquay',
        'Camel Valley Vineyard, Bodmin',
        'The Witchcraft Museum, Boscastle',
        'Lanhydrock House and Garden, Bodmin',
        'Pencarrow House and Gardens, Bodmin',
        'King Arthur\'s Great Halls, Tintagel',
        'Carnglaze Caverns, Liskeard',
        'Looe Beach, Looe',
        'Polperro Harbour, Polperro',
        'Charlestown Harbour, Charlestown',
        'Geevor Tin Mine, Pendeen',
        'Penlee House Gallery and Museum, Penzance',
        'Tremenheere Sculpture Gardens, Penzance',
        'St. Ives Museum, St. Ives',
        'Minack Theatre, Porthcurno',
        'Truro Cathedral, Truro',
        'Holywell Bay, Newquay',
        'Trelissick Garden, Truro',
        'St. Clement\'s Isle, Mousehole',
        'National Maritime Museum Cornwall, Falmouth',
        'St. Anthony Head Walk, St. Mawes',
        'Prideaux Place, Padstow',
        'Buckingham Palace, London',
        'Tower Bridge, London',
        'Big Ben, London',
        'The Shard, London',
        'London Eye, London',
        'Westminster Abbey, London',
        'British Museum, London',
        'Tate Modern, London',
        'Victoria and Albert Museum, London',
        'Natural History Museum, London',
        'Hyde Park, London',
        'Kensington Palace, London',
        'St. Paul\'s Cathedral, London',
        'The Houses of Parliament, London',
        'The Millennium Bridge, London',
        'The National Gallery, London',
        'The Tower of London, London',
        'Hampton Court Palace, East Molesey',
        'Kew Gardens, London',
        'The Royal Observatory, Greenwich',
        'The O2, London',
        'The Victoria and Albert Museum, London',
        'The Science Museum, London',
        'The Royal Albert Hall, London',
        'The British Library, London',
        'The West End Theatres, London',
        'The National Portrait Gallery, London',
        'The Imperial War Museum, London',
        'The Design Museum, London',
        'The Cutty Sark, London',
        'The Cartoon Museum, London',
        'The Florence Nightingale Museum, London',
        'The Tate Britain, London',
        'The Whitechapel Gallery, London',
        'The Horniman Museum and Gardens, London',
        'The Royal Air Force Museum, London',
        'The Sherlock Holmes Museum, London',
        'The Tower Bridge Exhibition, London',
        'The Hunterian Museum, London',
        'The Monument to the Great Fire of London, London',
        'The Museum of London, London',
        'The Royal Hospital Chelsea, London',
        'The Saatchi Gallery, London',
        'The Wallace Collection, London',
        'The Old Royal Naval College, London',
        'The Geffrye Museum, London',
        'The Serpentine Galleries, London',
        'The Charles Dickens Museum, London',
        'The Royal Academy of Arts, London',
        'The Old Operating Theatre Museum and Herb Garret, London',
        'The London Transport Museum, London',
        'The Wellcome Collection, London',
        'The Bank of England Museum, London',
        'The Tate Liverpool, Liverpool',
        'The Royal Liver Building, Liverpool',
        'The Walker Art Gallery, Liverpool',
        'The Beatles Story, Liverpool',
        'The Merseyside Maritime Museum, Liverpool',
        'The World Museum, Liverpool',
        'The Metropolitan Cathedral, Liverpool',
        'The Museum of Liverpool, Liverpool',
        'The Cavern Club, Liverpool',
        'The Albert Dock, Liverpool',
        'The Western Approaches Museum, Liverpool',
        'The Pier Head, Liverpool',
        'The St. George\'s Hall, Liverpool',
        'The Bluecoat Chambers, Liverpool',
        'The Liverpool Central Library, Liverpool',
        'The International Slavery Museum, Liverpool',
        'The Liverpool Empire Theatre, Liverpool',
        'The Royal Court Theatre, Liverpool',
        'The Liverpool Cathedral, Liverpool',
        'The Liverpool ONE, Liverpool',
        'The Tate St. Ives, St. Ives',
        'The Eden Project, Bodelva',
        'The Minack Theatre, Porthcurno',
        'The Lizard Lighthouse, The Lizard',
        'The Land\'s End, Sennen',
        'The St. Michael\'s Mount, Marazion',
        'The Godrevy Lighthouse, Hayle',
        'The St. Mawes Castle, St. Mawes',
        'The Porthcurno Beach, Porthcurno',
        'The St. Enodoc Church, Trebetherick',
        'The Camel Valley Vineyard, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Bodmin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Barbara Hepworth Museum and Sculpture Garden, St. Ives',
        'The Heligan Gardens, St. Austell',
        'The Lizard Point, Lizard',
        'The St. Agnes Head, St. Agnes',
        'The Porthminster Beach, St. Ives',
        'The Port Isaac Harbour, Port Isaac',
        'The Lost Gardens of Heligan, St. Austell',
        'The Porthleven Harbour and Dock Company, Porthleven',
        'The St. Mawes Castle, St. Mawes',
        'The St. Nicholas Chapel, St. Ives',
        'The Porthcurno Beach, Porthcurno',
        'The Barbra Hepworth Museum and Sculpture Garden, St. Ives',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Boddin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Boddin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Boddin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Boddin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel',
        'The Padstow Harbour, Padstow',
        'The Perranporth Beach, Perranporth',
        'The Boddin Moor, Bodmin',
        'The Bude Sea Pool, Bude',
        'The Blue Reef Aquarium, Newquay',
        'The Newquay Zoo, Newquay',
        'The Porthcurno Telegraph Museum, Porthcurno',
        'The St. Petroc\'s Church, Bodmin',
        'The Lappa Valley Steam Railway, Newquay',
        'The Carnglaze Caverns, Liskeard',
        'The Lanhydrock House and Garden, Bodmin',
        'The Pencarrow House and Gardens, Bodmin',
        'The King Arthur\'s Great Halls, Tintagel'
     ],


];
