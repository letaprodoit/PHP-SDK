#PassKit SDK for PHP

![PassKit Logo](https://passkit.com/images/passkit-logo.png)

##Description

###&nbsp;&nbsp;&nbsp;&nbsp;The PassKit SDK enables user to efficiently connect to the PassKit API. To use this SDK, you will need an account with PassKit.

##0. Prerequisites

###&nbsp;&nbsp;&nbsp;&nbsp;Import passkitSDK

```php
include_once "[PATH TO passkit-v2-sdk.php]";
```

##1. PassKit

###&nbsp;&nbsp;&nbsp;&nbsp;Create PassKit

```php
$pk = new PassKit("apiKey","apiSecret");
```

##2. Campaign <<<<<<< HERE >>>>>>>

###&nbsp;&nbsp;&nbsp;&nbsp;Create Campaign
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the created campaign.

```php
$data = array('name' => 'MyCampaign','passbookCertId' => 'MyPassbookCertId','startDate' => '2016-01-01T00:00:00Z');
// refer to `https://dev.passkit.net/#create-a-campaign` for a complete attribute list.
$result = $pk->CreateCampaign($data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve Campaign
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the retrieved campaign.

```php
$result = $pk->GetCampaign('MyCampaign');
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve All Campaigns
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of all retrieved campaigns.

```php
$result = $pk->ListCampaigns();
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Campaign
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the updated campaign.

```php
$data = array('displayName' => 'MyCampaignDisplayName');
// refer to `https://dev.passkit.net/#update-a-campaign` for a complete attribute list.
$result = $pk->UpdateCampaign('MyCampaign',$data);
```

##3. Template

###&nbsp;&nbsp;&nbsp;&nbsp;Create Template
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the created template.

```php
$data_passbook = array('type' => 'storeCard','desc' => 'Description of the template');
$data = array('name' => 'MyTemplate','campaignName' => 'MyCampaign','language' => 'en','startDate' => '2016-01-01T00:00:00Z', 'passbook' => $data_passbook);
$image_files = array('passbook-IconFile' => 'FILE');
// refer to `https://dev.passkit.net/#create-a-template` for a complete attribute list.
$result = $pk->CreateTemplate($data,$image_files);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve Template
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the retrieved template.

```php
$result = $pk->GetTemplate('MyTemplate');
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve All Templates
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of all retrieved templates.

```php
$result = $pk->ListTemplatesByCampaign('MyCampaign');
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Template
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the updated template.

```php
$data = array('language' => 'de');
// refer to `https://dev.passkit.net/#update-a-template` for a complete attribute list.
$result = $pk->UpdateTemplateData('MyTemplate',$data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Template with images
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the updated template.

```php
$data = array('language' => 'fr');
$image_files = array('passbook-IconFile' => 'FILE2');
// refer to `https://dev.passkit.net/#update-a-template-with-images` for a complete attribute list.
$result = $pk->UpdateTemplateData('MyTemplate',$data,$image_files);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Push Update
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the name of the pushed updated template.
```php
$result = $pk->PushTemplateUpdate('MyTemplate');
```

##4. Pass

###&nbsp;&nbsp;&nbsp;&nbsp;Create Pass
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the id of the created pass.

```php
$data = array('templateName' => 'MyTemplate');
// refer to `https://dev.passkit.net/#create-a-pass` for a complete attribute list.
$result = $pk->CreatePass($data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve Pass
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the retrieved pass.

```php
$result = $pk->GetPassById('PassId');
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve Pass with userDefinedId
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the retrieved pass.

```php
$result = $pk->GetPassByUserDefinedId('UserDefinedID');
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Pass
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the id of the updated pass.

```php
$data = array('recoveryEmail' => 'apoorva@passkit.com');
// refer to `https://dev.passkit.net/#update-a-pass` for a complete attribute list.
$result = $pk->UpdatePassById('PassId',$data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Pass with userDefinedId
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the id of the updated pass.

```php
$data = array('recoveryEmail' => 'apoorva@passkit.com');
// refer to `https://dev.passkit.net/#updating-a-pass-with-a-user-defined-id` for a complete attribute list.
$result = $pk->UpdatePassByUserDefinedId('UserDefinedID','MyCampaign',$data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Redeem Pass
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the id of the redeemed pass.

```php
//Not offered yet
```

###&nbsp;&nbsp;&nbsp;&nbsp;Create Pass Batch
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the ids of the created passes.

```php
$data = array('passes' => array(array('templateName' => 'MyTemplate'),array('templateName' => 'MyTemplate')));
// refer to `https://dev.passkit.net/#batch-create-passes` for a complete attribute list.
$result = $pk->CreatePassBatch($data);
```

###&nbsp;&nbsp;&nbsp;&nbsp;Retrieve Pass Batch
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the retrieved passes.

```php
//Not offered yet
```

###&nbsp;&nbsp;&nbsp;&nbsp;Update Pass Batch
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the ids of the updated passes.

```php
$data = array('passes' => array(array('passId' => 'PassId','recoveryEmail' => 'apoorvakatta@gmail.com'),array('passId' => 'PassId','recoveryEmail' => 'apoorvakatta@gmail.com')));
// refer to `https://dev.passkit.net/#batch-update-passes` for a complete attribute list.
$result = $pk->UpdatePassBatch($data);
```

##5. Search
###&nbsp;&nbsp;&nbsp;&nbsp;Initiate Pass Search
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the search result of the searched pass.

```php
//Not offered yet
```

##6. Images

###&nbsp;&nbsp;&nbsp;&nbsp;Upload Image
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the path of the uploaded image.

```php
//Not offered yet
```

##7. Recovery Email

###&nbsp;&nbsp;&nbsp;&nbsp;Resend Single Recovery Email
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the resent recovery email.

```php
//Not offered yet
```

###&nbsp;&nbsp;&nbsp;&nbsp;Resend Multiple Recovery Email
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;returns the details of the resent recovery emails.

```php
//Not offered yet
```

##8. Supplementary Functions

```php
$result = $pk.GenerateCSR();
```

```php
//Upload certificate not available
```

```php
$result = $pk.GetCertificateDetails('MyCertificateId');
```

```php
$result = $pk.ListCertificates();
```