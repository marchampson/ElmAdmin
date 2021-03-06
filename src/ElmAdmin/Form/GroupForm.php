<?php
namespace ElmAdmin\Form;

use Zend\Form\Form as Form;
use Zend\Form\Fieldset;
use Zend\Form\Element as Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\InputFilter;

class GroupForm extends Form implements InputFilterProviderInterface
{
	protected $fieldsetArray;
	
	public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('group');
        $this->setAttribute('method', 'post');
        
        /*
	     * Hidden Elements
	     */
	    $id = new Element\Hidden('id');
        
        $group_id = new Element\Select('group_id');
        $group_id->setLabel('User group');
        
		$type = new Element\Select('type');
		$type->setLabel('Group Type')
			   ->setOptions(array('options' => array('' => 'Select one', 'company' => 'Company', 'team' => 'Team')));
		
		$reference = new Element\Text('reference');
		$reference->setLabel('Reference');

		$name = new Element\Text('name');
		$name->setLabel('Name');
		
		$address1 = new Element\Text('address1');
		$address1->setLabel('Address 1');
		
		$address2 = new Element\Text('address2');
		$address2->setLabel('Address 2');
		
		$town = new Element\Text('town');
		$town->setLabel('Town');
		
		$county = new Element\Select('county');
		$county->setLabel('County');
		$countiesArray = array(
		        "" => "Select one",
		        "Avon"=>"Avon",
		        "Bedfordshire"=>"Bedfordshire",
		        "Berkshire"=>"Berkshire",
		        "Borders"=>"Borders",
		        "Buckinghamshire"=>"Buckinghamshire",
		        "Cambridgeshire"=>"Cambridgeshire",
		        "Central"=>"Central",
		        "Cheshire"=>"Cheshire",
		        "Cleveland"=>"Cleveland",
		        "Clwyd"=>"Clwyd",
		        "Cornwall"=>"Cornwall",
		        "County Antrim"=>"County Antrim",
		        "County Armagh"=>"County Armagh",
		        "County Down"=>"County Down",
		        "County Fermanagh"=>"County Fermanagh",
		        "County Londonderry"=>"County Londonderry",
		        "County Tyrone"=>"County Tyrone",
		        "Cumbria"=>"Cumbria",
		        "Derbyshire"=>"Derbyshire",
		        "Devon"=>"Devon",
		        "Dorset"=>"Dorset",
		        "Dumfries and Galloway"=>"Dumfries and Galloway",
		        "Durham"=>"Durham",
		        "Dyfed"=>"Dyfed",
		        "East Sussex"=>"East Sussex",
		        "Essex"=>"Essex",
		        "Fife"=>"Fife",
		        "Gloucestershire"=>"Gloucestershire",
		        "Grampian"=>"Grampian",
		        "Greater Manchester"=>"Greater Manchester",
		        "Gwent"=>"Gwent",
		        "Gwynedd County"=>"Gwynedd County",
		        "Hampshire"=>"Hampshire",
		        "Herefordshire"=>"Herefordshire",
		        "Hertfordshire"=>"Hertfordshire",
		        "Highlands and Islands"=>"Highlands and Islands",
		        "Humberside"=>"Humberside",
		        "Isle of Wight"=>"Isle of Wight",
		        "Kent"=>"Kent",
		        "Lancashire"=>"Lancashire",
		        "Leicestershire"=>"Leicestershire",
		        "Lincolnshire"=>"Lincolnshire",
		        "Lothian"=>"Lothian",
		        "Merseyside"=>"Merseyside",
		        "Mid Glamorgan"=>"Mid Glamorgan",
		        "Norfolk"=>"Norfolk",
		        "North Yorkshire"=>"North Yorkshire",
		        "Northamptonshire"=>"Northamptonshire",
		        "Northumberland"=>"Northumberland",
		        "Nottinghamshire"=>"Nottinghamshire",
		        "Oxfordshire"=>"Oxfordshire",
		        "Powys"=>"Powys",
		        "Rutland"=>"Rutland",
		        "Shropshire"=>"Shropshire",
		        "Somerset"=>"Somerset",
		        "South Glamorgan"=>"South Glamorgan",
		        "South Yorkshire"=>"South Yorkshire",
		        "Staffordshire"=>"Staffordshire",
		        "Strathclyde"=>"Strathclyde",
		        "Suffolk"=>"Suffolk",
		        "Surrey"=>"Surrey",
		        "Tayside"=>"Tayside",
		        "Tyne and Wear"=>"Tyne and Wear",
		        "Warwickshire"=>"Warwickshire",
		        "West Glamorgan"=>"West Glamorgan",
		        "West Midlands"=>"West Midlands",
		        "West Sussex"=>"West Sussex",
		        "West Yorkshire"=>"West Yorkshire",
		        "Wiltshire"=>"Wiltshire",
		        "Worcestershire"=>"Worcestershire"
		);
		//$optionsArray = array_merge(array('' => 'Select one'), $countiesArray);
        $county->setOptions(array('options'=>$countiesArray));		
		    		
		$postcode = new Element\Text('postcode');
		$postcode->setLabel('Postcode');
		
		$country = new Element\Select('country');
		$country->setLabel('Country');
		$countriesArray = array(
		        '' => 'Select one',
				'AD' => 'Andorra',
				'AE' => 'United Arab Emirates',
				'AF' => 'Afghanistan',
				'AG' => 'Antigua and Barbuda',
				'AI' => 'Anguilla',
				'AL' => 'Albania',
				'AM' => 'Armenia',
				'AN' => 'Netherlands Antilles',
				'AO' => 'Angola',
				'AQ' => 'Antarctica',
				'AR' => 'Argentina',
				'AS' => 'American Samoa',
				'AT' => 'Austria',
				'AU' => 'Australia',
				'AW' => 'Aruba',
				'AZ' => 'Azerbaijan',
				'BA' => 'Bosnia and Herzegovina',
				'BB' => 'Barbados',
				'BD' => 'Bangladesh',
				'BE' => 'Belgium',
				'BF' => 'Burkina Faso',
				'BG' => 'Bulgaria',
				'BH' => 'Bahrain',
				'BI' => 'Burundi',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BN' => 'Brunei Darrussalam',
				'BO' => 'Bolivia',
				'BR' => 'Brazil',
				'BS' => 'Bahamas',
				'BT' => 'Bhutan',
				'BV' => 'Bouvet Island',
				'BW' => 'Botswana',
				'BY' => 'Belarus',
				'BZ' => 'Belize',
				'CA' => 'Canada',
				'CC' => 'Cocos (keeling) Islands',
				'CD' => 'Congo, Democratic People�s Republic',
				'CF' => 'Central African Republic',
				'CG' => 'Congo, Republic of',
				'CH' => 'Switzerland',
				'CI' => 'Cote d�Ivoire',
				'CK' => 'Cook Islands',
				'CL' => 'Chile',
				'CM' => 'Cameroon',
				'CN' => 'China',
				'CO' => 'Colombia',
				'CR' => 'Costa Rica',
				'CS' => 'Serbia and Montenegro',
				'CU' => 'Cuba',
				'CV' => 'Cap Verde',
				'CS' => 'Christmas Island',
				'CY' => 'Cyprus Island',
				'CZ' => 'Czech Republic',
				'DE' => 'Germany',
				'DJ' => 'Djibouti',
				'DK' => 'Denmark',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'DZ' => 'Algeria',
				'EC' => 'Ecuador',
				'EE' => 'Estonia',
				'EG' => 'Egypt',
				'EH' => 'Western Sahara',
				'ER' => 'Eritrea',
				'ES' => 'Spain',
				'ET' => 'Ethiopia',
				'FI' => 'Finland',
				'FJ' => 'Fiji',
				'FK' => 'Falkland Islands (Malvina)',
				'FM' => 'Micronesia, Federal State of',
				'FO' => 'Faroe Islands',
				'FR' => 'France',
				'GA' => 'Gabon',
				'GD' => 'Grenada',
				'GE' => 'Georgia',
				'GF' => 'French Guiana',
				'GG' => 'Guernsey',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GL' => 'Greenland',
				'GM' => 'Gambia',
				'GN' => 'Guinea',
				'GP' => 'Guadeloupe',
				'GQ' => 'Equatorial Guinea',
				'GR' => 'Greece',
				'GS' => 'South Georgia',
				'GT' => 'Guatemala',
				'GU' => 'Guam',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HK' => 'Hong Kong',
				'HM' => 'Heard and McDonald Islands',
				'HN' => 'Honduras',
				'HR' => 'Croatia/Hrvatska',
				'HT' => 'Haiti',
				'HU' => 'Hungary',
				'ID' => 'Indonesia',
				'IE' => 'Ireland',
				'IL' => 'Israel',
				'IM' => 'Isle of Man',
				'IN' => 'India',
				'IO' => 'British Indian Ocean Territory',
				'IQ' => 'Iraq',
				'IR' => 'Iran (Islamic Republic of)',
				'IS' => 'Iceland',
				'IT' => 'Italy',
				'JE' => 'Jersey',
				'JM' => 'Jamaica',
				'JO' => 'Jordan',
				'JP' => 'Japan',
				'KE' => 'Kenya',
				'KG' => 'Kyrgyzstan',
				'KH' => 'Cambodia',
				'KI' => 'Kiribati',
				'KM' => 'Comoros',
				'KN' => 'Saint Kitts and Nevis',
				'KP' => 'Korea, Democratic People�s Republic',
				'KR' => 'Korea, Republic of',
				'KW' => 'Kuwait',
				'KY' => 'Cayman Islands',
				'KZ' => 'Kazakhstan',
				'LA' => 'Lao People�s Democratic Republic',
				'LB' => 'Lebanon',
				'LC' => 'Saint Lucia',
				'LI' => 'Liechtenstein',
				'LK' => 'Sri Lanka',
				'LR' => 'Liberia',
				'LS' => 'Lesotho',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourgh',
				'LV' => 'Latvia',
				'LY' => 'Libyan Arab Jamahiriya',
				'MA' => 'Morocco',
				'MC' => 'Monaco',
				'MD' => 'Moldova, Republic of',
				'MG' => 'Madagascar',
				'MH' => 'Marshall Islands',
				'MK' => 'Macedonia',
				'ML' => 'Mali',
				'MM' => 'Myanmar',
				'MN' => 'Mongolia',
				'MO' => 'Macau',
				'MP' => 'Northern Mariana Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MS' => 'Montserrat',
				'MT' => 'Malta',
				'MU' => 'Mauritius',
				'Mv' => 'Maldives',
				'MW' => 'malawi',
				'MX' => 'Mexico',
				'MY' => 'Malaysia',
				'MZ' => 'Mozambique',
				'NA' => 'Namibia',
				'NC' => 'New Caledonia',
				'NE' => 'Niger',
				'NF' => 'Norfolk Island',
				'NG' => 'Nigeria',
				'NI' => 'Nicaragua',
				'NL' => 'Netherlands',
				'NO' => 'Norway',
				'NP' => 'Nepal',
				'NR' => 'Nauru',
				'NU' => 'Niue',
				'NZ' => 'New Zealand',
				'OM' => 'Oman',
				'PA' => 'Panama',
				'PE' => 'Peru',
				'PF' => 'French Polynesia',
				'PG' => 'papua New Guinea',
				'PH' => 'Phillipines',
				'PK' => 'Pakistan',
				'PL' => 'Poland',
				'PM' => 'St. Pierre and Miquelon',
				'PN' => 'Pitcairn Island',
				'PR' => 'Puerto Rico',
				'PS' => 'Palestinian Territories',
				'PT' => 'Portugal',
				'PW' => 'Palau',
				'PY' => 'Paraguay',
				'QA' => 'Qatar',
				'RE' => 'Reunion Island',
				'RO' => 'Romania',
				'RU' => 'Russian Federation',
				'RW' => 'Rwanda',
				'SA' => 'Saudi Arabia',
				'SB' => 'Solomon Islands',
				'SC' => 'Seychelles',
				'SD' => 'Sudan',
				'SE' => 'Sweden',
				'SG' => 'Singapore',
				'SH' => 'St. Helena',
				'SI' => 'Slovenia',
				'SJ' => 'Svalbard and Jan Mayen Islands',
				'SK' => 'Slovak Republic',
				'SL' => 'Sierra Leone',
				'SM' => 'San Marino',
				'SN' => 'Senegal',
				'SO' => 'Somalia',
				'SR' => 'Suriname',
				'ST' => 'Sao Tome and Principe',
				'SV' => 'El Salvador',
				'SY' => 'Syrian Arab Republic',
				'SZ' => 'Swaziland',
				'TC' => 'Turks and Caicos Islands',
				'TD' => 'Chad',
				'TF' => 'French Southern Territories',
				'TG' => 'Togo',
				'TH' => 'Thailand',
				'TJ' => 'Tajikistan',
				'TK' => 'Tokelau',
				'TM' => 'Turkmenistan',
				'TN' => 'Tunisia',
				'TO' => 'Tonga',
				'TP' => 'East Timor',
				'TR' => 'Turkey',
				'TT' => 'Trinidad and Tobago',
				'TV' => 'Tuvalu',
				'TW' => 'Taiwan',
				'TZ' => 'Tanzania',
				'UA' => 'Ukraine',
				'UG' => 'Uganda',
				'UM' => 'US Minor Outlying Islands',
		        'GB' => 'United Kingdom (GB)',
				'US' => 'United States',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VA' => 'Holy See (City Vatican State)',
				'VC' => 'Saint Vincent and the Grenadines',
				'VE' => 'Venezuela',
				'VG' => 'Virgin Islands (British)',
				'VI' => 'Virgin Islands (USA)',
				'VN' => 'Vietnam',
				'VU' => 'Vanuatu',
				'WF' => 'Wallis and Futuna Islands',
				'WS' => 'Western Samoa',
				'YE' => 'Yemen',
				'YT' => 'Mayotte',
				'YU' => 'Yugoslavia',
				'ZA' => 'South Africa',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe'
);
		$country->setOptions(array('options'=>array_merge(array(''=>'Select one'), $countriesArray)));
		
		$this->fieldsetArray = array(
				'Group Details' => array(
						'id',
						'type',
						'name',
				        'reference',
						'address1',
						'address2',
						'town',
						'county',
						'postcode',
						'country'
				),
		);

		$this->add($id)
		     ->add($type)
			 ->add($name)
			 ->add($reference)
			 ->add($address1)
			 ->add($address2)
			 ->add($town)
			 ->add($county)
			 ->add($postcode)
			 ->add($country);
			 
	}
	
	public function getFieldsetArray()
	{
		return $this->fieldsetArray;
	}
	
	/**
	 * @return array
	 */
	public function getInputFilterSpecification()
	{
		return array(
				'group_id' => array(
						'required' => false,
	
				),
                                'county' => array(
						'required' => false,
	
				)
		);
	}
}