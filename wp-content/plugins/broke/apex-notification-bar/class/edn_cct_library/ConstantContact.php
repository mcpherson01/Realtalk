<?php
require_once('Authentication.php'); // OAuth & Basic Authentication classes (CTCTDataStore, EDN_CTCTRequest, OAuthToken...)
require_once('Collections.php'); // Constant Contact collection resource classes (ContactsCollection, ListsCollection..)
require_once('Components.php'); // Constant Contact object classes (Contact, List, Campaign, Event...)

if ( !class_exists( 'EDN_ConstantContact' ) ) {
class EDN_ConstantContact{
    public $apiKey;
    public $username;
    public $password;
    public $consumerSecret;
    public $EDN_CTCTRequest;
    public $authType;

    /**
     * EDN_ConstantContact constructor
     * @param string $authType - Authentication type, 'basic' or 'oauth'
     * @param string $apiKey - Constant Contact API key
     * @param string $username - Constant Contact Username
     * @param string $param - For basic - password, for oauth - consumerSecret
     * @return void
     */
    public function __construct($authType, $apiKey, $username, $param){
    	
    	// Set username to the instance so we can use it if neccessary
    	$this->username = $username;
    	
        try{
        $this->authType = strtolower($authType);
        if($this->authType != 'basic' && $this->authType != 'oauth' && $this->authType != 'oauth2'){
            throw new EDN_CTCTException('Authentication Error: type '.$this->authType.' is not valid');
        };
        $this->EDN_CTCTRequest = new EDN_CTCTRequest($this->authType, $apiKey, $username, $param);
 
        } catch (EDN_CTCTException $e){

            $e->generateError();
        }
    }

    /**
     * Get a page of Lists
     * @param string $page - optional 'nextLink' returned from a previous getLists() call
	 * @param bool $systemLists - set to true to return the 'Active', 'Removed' and 'Do Not Mail' system lists
     * @return array - Up to 50 Lists and a link to the next page if one exists
     */
    public function getLists($page=null, $systemLists=false){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        return $ListsCollection->getLists($page, $systemLists);
    }

    /**
     * Get a page of list members
     * @param ContactList $item - ContactList object
	 * @param string $page - optional 'nextLink' returned from a previous getListMembers() call
     * @return array
     */
    public function getListMembers(EDN_ContactList $List, $page=null){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        if($page){$url = $this->EDN_CTCTRequest->baseUri;}
        return $ListsCollection->getListMembers($List, $page);
    }

    /**
     * Get full details for a list
     * @param ContactList $item - ContactList object
     * @return ContactList
     */
    public function getListDetails(EDN_ContactList $List){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        return $ListsCollection->getListDetails($this->EDN_CTCTRequest->baseUri.$List->link);
    }

    /**
     * Create a new ContactList
     * @param ContactList $List - ContactList object
     * @return ContactList
     */
    public function addList(EDN_ContactList $List){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        return $ListsCollection->addList($List);
    }

    /**
     * Deletes a ContactList
     * @param ContactList $List - ContactList object
     * @return bool
     */
    public function deleteList(EDN_ContactList $List){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        return $ListsCollection->deleteList($this->EDN_CTCTRequest->baseUri.$List->link);
    }

    /**
     * Update a ContactList with its current properties
     * @param ContactList $List - ContactList object
     * @return bool
     */
    public function updateList(EDN_ContactList $List){
        $ListsCollection = new EDN_ListsCollection($this->EDN_CTCTRequest);
        return $ListsCollection->updateList($List);
    }

    /**
     * Add a new Contact to a Constant Contact account
     * @param Contact $Contact  - Contact Object
     * @return Contact
     */
    public function addContact(EDN_Contact $Contact){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->addContact($Contact);
    }

    /**
     * Get a page of Contacts
     * @param string $page - optional 'nextLink' returned from a previous getContacts() call
     * @return array - Up to 50 Contacts and a link to the next page if one exists
     */
    public function getContacts($page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->getContacts($page);                
    }

    /**
     * Get full details for a Contact
     * @param Contact $Contact - Contact object
     * @return Contact
     */
    public function getContactDetails(EDN_ContactEDN_Contact $Contact){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->getContactDetails($this->EDN_CTCTRequest->baseUri.$Contact->link);
    }

    /**
     * Get open events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactOpens call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactOpens(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/opens';
        return $ContactsCollection->getContactEvents($url, 'OpenEvent');
    }

    /**
     * Get click events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactClicks call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactClicks(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/clicks';
        return $ContactsCollection->getContactEvents($url, 'ClickEvent');
    }

    /**
     * Get forwards events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactForwards call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactForwards(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/forwards';
        return $ContactsCollection->getContactEvents($url, 'ForwardEvent');
    }

    /**
     * Get bounce events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactBounces call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactBounces(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/bounces';
        return $ContactsCollection->getContactEvents($url, 'BounceEvent');
    }

    /**
     * Get opt out events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactOptOuts call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactOptOuts(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/optouts';
        return $ContactsCollection->getContactEvents($url, 'OptoutEvent');
    }

    /**
     * Get send events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactSends call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getContactSends(EDN_Contact $Contact, $page=null){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Contact->link.'/events/sends';
        return $ContactsCollection->getContactEvents($url, 'SentEvent');
    }

    /**
     * Update a contact with current properties
     * @param Contact $Contact - Contact object
     * @return Contact
     */
    public function updateContact(EDN_Contact $Contact){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->updateContact($Contact);
    }

    /**
     * Delete a contact
     * @param Contact $Contact - Contact
     * @return bool
     */
    public function deleteContact(EDN_Contact $Contact){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->deleteContact($this->EDN_CTCTRequest->baseUri.$Contact->link);
    }

    /**
     * Search for contacts by email address
     * @param string $emailAddress - email address of user to search for
     * @param array $emailAddress - array of email addresses to search for
     * @return - array of found contacts, otherwise returns false
     */
    public function searchContactsByEmail($emailAddress){
        $ext = '';
        if(is_string($emailAddress)){$ext = '?email='.$emailAddress;}
        if(is_array($emailAddress)){
            for($i=0; $i<count($emailAddress); $i++){
                $ext .= ($i==0) ? '?email='.$emailAddress[$i] : '&email='.$emailAddress[$i];
            }
        }
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->searchContactsByEmail($ext);
    }

    /**
     * Search for contacts in a list who have been updated since a given date
     * @param ContactList $List - ContactList object to search
     * @param  string $date - Last updated date to search from
     * @return array - Up to 50 contacts and a link to the next page if one exists
     */
    public function searchContactsByLastUpdate(EDN_ContactList $List, $date){
        $ContactsCollection = new EDN_ContactsCollection($this->EDN_CTCTRequest);
        return $ContactsCollection->searchContactsByLastUpdate($List, $date);
    }

    /**
     * Get a page of Campaigns
     * @param string $page - optional 'nextLink' returned from a previous getLists() call
     * @return array - Up to 50 Campaigns and a link to the next page if one exists
     */
    public function getCampaigns($page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->getCampaigns($page);
    }

    /**
     * Get full details for a Campaign
     * @param Campaign $item - Campaign object
     */
    public function getCampaignDetails(EDN_Campaign $Campaign){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->getCampaignDetails($this->EDN_CTCTRequest->baseUri.$Campaign->link);
    }

    /**
     * Get events from a campaign
     * @param Campaign $Campaign - Campaign to get events for
     * @param string  $eventType - Sends, Forwards,  Bounces, OptOuts, Opens
     * @return array
     */
    public function getCampaignEvents(Campaign $Campaign, $eventType){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->getCampaignEvents($Campaign, $eventType);
    }

   /**
     * Get open events for a contact
     * @param Campaign $Campaign
     * @param string $page - optional 'nextLink' from previous getContactOpens call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getCampaignOpens(EDN_Campaign $Campaign, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Campaign->link.'/events/opens';
        return $CampaignsCollection->getCampaignEvents($url, 'OpenEvent');
    }

    /**
     * Get forwards events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactForwards call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getCampaignForwards(EDN_Campaign $Campaign, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Campaign->link.'/events/forwards';
        return $CampaignsCollection->getCampaignEvents($url, 'ForwardEvent');
    }

    /**
     * Get bounce events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactBounces call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getCampaignBounces(EDN_Campaign $Campaign, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Campaign->link.'/events/bounces';
        return $CampaignsCollection->getCampaignEvents($url, 'BounceEvent');
    }

    /**
     * Get opt out events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactOptOuts call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getCampaignOptOuts(EDN_Campaign $Campaign, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Campaign->link.'/events/optouts';
        return $CampaignsCollection->getCampaignEvents($url, 'OptOutEvent');
    }

    /**
     * Get send events for a contact
     * @param Contact $Contact
     * @param string $page - optional 'nextLink' from previous getContactSends call
     * @return array - Up to 50 CampaignEvents and a link to the next page if one exists
     */
    public function getCampaignSends(EDN_Campaign $Campaign, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        $url = ($page) ? $this->EDN_CTCTRequest->baseUri.$page : $this->EDN_CTCTRequest->baseUri.$Campaign->link.'/events/sends';
        return $CampaignsCollection->getCampaignEvents($url, 'SentEvent');
    }

    /**
     * Get a page of campaigns in a particular status
     * @param string $status - status of campaign to search for (sent, draft, running, scheduled)
     * @return array - Up to 50 Campaigns and a link to the next page if one exists 
     */
    public function getCampaignsByStatus($status, $page=null){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->getCampaignsByStatus($status, $page);
    }

    /**
     * Schedule an email campaign for delivery
     * @param Campaign $Campaign - Email to be delivered
     * @param string $time - Date/Time for email to be sent
     * @return bool - true if successful, else false
     */
    public function scheduleCampaign(EDN_Campaign $Campaign, $time){
        $CampaignCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignCollection->scheduleCampaign($Campaign, $time);
    }

    /**
     * Get Schedule for a campaign in scheduled status
     * @param Campaign $Campaign - Campaign to get a schedule for
     * @return bool|Schedule - returns Schedule if found, else false
     */
    public function getCampaignSchedule(EDN_Campaign $Campaign){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->getSchedule($Campaign);
    }

    /**
     * Delete a schedule from a campaign (prevent it from sending)
     * @param Campaign $Campaign - Campaign to delete schedule for
     * @return bool - true if successful, else false
     */
    public function deleteCampaignSchedule(Campaign $Campaign){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->deleteSchedule($Campaign);
    }

    /**
     * Delete an email Campaign
     * @param Campaign $Campaign - Campaign object
     */
    public function deleteCampaign(EDN_Campaign $Campaign){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->deleteCampaign($this->EDN_CTCTRequest->baseUri.$Campaign->link);
    }

    /**
     * @param array $params - associate array of Campaign properties
     * @param VerifiedAddress $fromEmail - from email for the campaign
     * @param VerifiedAddress $replyEmail - OPTIONAL: reply email if different than fromEmail
     * @return Campaign
     */
    public function addCampaign(EDN_Campaign $Campaign, VerifiedAddress $fromEmail, VerifiedAddress $replyEmail = null){
        $replyEmail = ($replyEmail) ? $replyEmail : $fromEmail;
        $Campaign->fromAddress = $fromEmail;
        $Campaign->replyAddress = $replyEmail;
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->addCampaign($Campaign);
    }

    /**
     * Update a campaign with its current properties
     * @param Campaign $Campaign - Campaign to update
     * @return
     */
    public function updateCampaign(EDN_Campaign $Campaign){
        $CampaignsCollection = new EDN_CampaignsCollection($this->EDN_CTCTRequest);
        return $CampaignsCollection->updateCampaign($Campaign);
    }

    /**
     * @param  Folder $Folder - Folder object
     * @return Folder - Folder object
     */
    public function addFolder(EDN_Folder $Folder){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->addFolder($Folder);
    }

    /**
     * Get a page of Folders
     * @param string $page - optional 'nextLink' returned from a previous getFolders() call
     * @return array - Up to 50 Folders and a link to the next page if one exists
     */
    public function getFolders($page=null){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->getFolders($page);
    }

    /**
     * Get a page of images from a folder
     * @param mixed $folder - Folder object
     * @return array - All images contained within the folder
     */
    public function getImagesFromFolder($folder){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->getImagesFromFolder($this->EDN_CTCTRequest->baseUri.$folder->link.'/images');
    }

    /**
     * Get detailed results for an image
     * @param Image  $image - image object
     * @return Image - Image object
     */
    public function getImageDetails(EDN_Image $Image){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->getImageDetails($this->EDN_CTCTRequest->baseUri.$Image->link);
    }

    /**
     * @param string $imageLocation - current location of image on disk
     * @param Folder $folder - Folder to upload image to
     * @return Image - created Image object
     */
    public function uploadImage($imageLocation, Folder $Folder){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->uploadImage($imageLocation, $this->EDN_CTCTRequest->baseUri.$Folder->link);
    }

    /**
     * Delete an image from your account
     * @param Image $Image - Image object
     * @return bool - true if successful, else false
     */
    public function deleteImage(EDN_Image $Image){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->deleteImage($this->EDN_CTCTRequest->baseUri.$Image->link);
    }

    /**
     * Delete all images from a folder
     * @param Folder $Folder - Folder object
     * @return bool - true if successful, else false
     */
    public function deleteImagesFromFolder(EDN_Folder $Folder){
        $LibraryCollection = new EDN_LibraryCollection($this->EDN_CTCTRequest);
        return $LibraryCollection->deleteImagesFromFolder($this->EDN_CTCTRequest->baseUri.$Folder->link.'/images');
    }

    /**
     * Get a list of verified email addresses in the account
     * @return array - Up to 50 Verified addresses and a link to the next page if one exists
     */
    public function getVerifiedAddresses($page=null){
        $SettingsCollection = new EDN_SettingsCollection($this->EDN_CTCTRequest);
        return $SettingsCollection->getAddresses($page);
    }

    /**
     * Get a page of Event objects
     * @param string $page - optional 'nextLink' returned from a previous getEvents() call
     * @return array - Up to 50 Images and a link to the next page if one exists
     */
    public function getEvents($page=null){
        $EventsCollection = new EDN_EventsCollection($this->EDN_CTCTRequest);
        return $EventsCollection->getEvents($page);
    }

    /**
     * Get all details for an event
     * @param  Event Event - Event object to get details for
     * @return Event
     */
    public function getEventDetails(Event $Event){
        $EventsCollection = new EDN_EventsCollection($this->EDN_CTCTRequest);
        return $EventsCollection->getEventDetails($this->EDN_CTCTRequest->baseUri.$Event->link);
    }

    /**
     * Get registrants from a particular event
     * @param Event $Event - Event Object
     * @return array - up to 50 registrants and a link to the next page if one exists
     */
    public function getRegistrants(Event $Event){
        $EventsCollection = new EDN_EventsCollection($this->EDN_CTCTRequest);
        return $EventsCollection->getRegistrants($this->EDN_CTCTRequest->baseUri.$Event->link.'/registrants');
    }

    /**
     * Get detailed information on a Registrant
     * @param Registrant $Registrant - Registrant Object
     * @return Registrant
     */
    public function getRegistrantDetails(Registrant $Registrant){
        $EventsCollection = new EDN_EventsCollection($this->EDN_CTCTRequest);
        return $EventsCollection->getRegistrantDetails($this->EDN_CTCTRequest->baseUri.$Registrant->link);
    }

    /**
     * Add multiple contacts at once
	 * @param string $postString - urlencoded string of data
	 * @return bool
     */
    public function bulkAddContacts($postString){
        $ActivitiesCollection = new EDN_ActivitiesCollection($this->EDN_CTCTRequest);
        return $ActivitiesCollection->bulkAddContacts($postString);

    }
}
}