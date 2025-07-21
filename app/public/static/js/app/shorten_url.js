var app = new Vue({
	el: '#shorten-url', 
	data: {
        longUrl: '',
        xxx: '',
        apiBaseUrl : '', 
        apiKey               : '', 
        ticketCats           : [], 
        ticketTitle          : '', 
        ticketReg            : '', 
        ticketDesc           : '',
        ticketAttachmentType : '',
        ticketAttachment     : '',
        noAttachment         : 'no',
        custId               : '', 
        userFname            : '', 
        userLname            : '', 
        userEmail            : '', 
        userPhone            : '', 
        ticketQueue          : '',
        projectId: ''
    }, 
    mounted: function() {

    }, 
    methods: {
        clearOldShortUrl: function() {
            document.getElementById('shortened-url').textContent = '';
        },
        shortenUrl: function() {
            var self = this
            var userToken = '';

            if (self.longUrl === "" || self.longUrl === null) {
                $.notify('Please provide a long url to shorten', "error");
                return false
            }
            else {
                const pattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;
                if (!pattern.test(self.longUrl)) {
                    $.notify('Please enter a valid long url', "error");
                    return false
                }
            }

            var url = '/api/shorten-url'

            axios.post(url, {
                long_url : self.longUrl          
            }, {
                headers: {
                    "Authorization" : 'Bearer '+userToken
                }
            })
            .then(function (response) {
                if (response.data.status === 'success') {
                    self.longUrl  = ''
                    $.notify(response.data.message, "success");
                    document.getElementById('shortened-url').textContent = response.data.shortened_url;
                }
                else {
                    $.notify(response.data.message, "error");
                }
            })
            .catch(function (error) {
                $.notify(response.data.message, "error");
                return false
            })
        },
        xxx: function() {
            //delete below
        },
        fetchApiKey: function() {
            var self = this

            self.apiBaseUrl = self.$refs.api_base_url.value
            console.log(self.apiBaseUrl)
            self.userToken = localStorage.getItem("geedesk_user_token");

            //Details from source of tikcet creation
            // self.custId = self.$refs.cust_id.value
            // self.userFname = self.$refs.user_fname.value
            // self.userLname = self.$refs.user_lname.value
            // self.userEmail = self.$refs.user_email.value
            // self.ticketQueue = self.$refs.ticket_queue.value
            // self.projectId = self.$refs.project_id.value

            //self.getTicketCats()
        }, 
        /*getTicketCats: function() {
            var self = this

            var url = self.baseUrl + 'tickets/create?api_key=' + self.apiKey
            axios.get(url)
            .then(function (response) {
                if (response.data.status != 'failed') 
                {
                    self.ticketCats = response.data
                }
                else 
                {
                    self.ticketCats = []
                }
            })
            .catch(function (error) {
                self.ticketCats = []
            })
        }, */
        // selectTicketReg: function(event) {
        //     var self = this

        //     self.ticketReg =  event.target.value
        //     console.log(self.ticketReg)
        // }, 
        onFileChange: function(e) {
            var self = this

            var files = e.target.files || e.dataTransfer.files;

            self.ticketAttachmentType = files[0]['type'];

            if(files[0]['type']==='image/jpeg'|| 
               files[0]['type']==='image/jpg' ||
               files[0]['type']==='image/png' ||
               files[0]['type']==='image/bmp' ||
               files[0]['type']==='image/gif'  ||
               files[0]['type']==='application/pdf')
            {

                if (!files.length) 
                {
                    self.noAttachment = 'no'
                    return;
                }
                else 
                {
                    self.noAttachment = 'yes'
                }
            }
            else
            {
                new_show_notify_message_no_reload("Error",'Please select the image or PDF to upload','error')
                return false
            }

            self.createImage(files[0]);
        }, 
        createImage(file) {
            var self = this

            var image = new Image();
            var reader = new FileReader();

            reader.onload = (e) => {
                self.ticketAttachment = e.target.result;
            };

            reader.readAsDataURL(file);
        },
        clearTicketAttachment: function() {
            var self = this
            self.ticketAttachment = ''
            self.noAttachment     = 'no'
        },
        createTicket: function() {
            var self = this

            if (self.ticketTitle === "" || self.ticketTitle === null) {
                new_show_notify_message_no_reload("Error",'Ticket title cannot be empty','error')
                return false
            }
            else if (self.ticketDesc === "" || self.ticketDesc === null) {
                new_show_notify_message_no_reload("Error",'Ticket description cannot be empty','error')
                return false
            }
            
            $("#create-btn").html("Creating...");
            $('#create-btn').prop('disabled', true);

            const fileInput = this.$refs.fileInput;
            var formData = new FormData();

            // Append form data
            formData.append('subject', self.ticketTitle);
            formData.append('description', self.ticketDesc);

            if (fileInput.files.length > 0) {
                formData.append('files', fileInput.files[0]);
            }

            var url = self.apiBaseUrl + '/admin/internal/support/tickets/create'

            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    "Authorization" : 'Bearer '+self.userToken
                }
            })
            .then(function (response) {
                if (response.data.success) {
                    self.ticketTitle = ''
                    self.ticketDesc = ''
                    fileInput.value = null;
                            /*var newTicketId = response.data.data.id
                            var redirectUrl = self.baseUrl + 'tickets/details/' + self.projectId + '/' + newTicketId
                            window.location.replace(redirectUrl);*/
                    new_show_notify_message_no_reload("Success",response.data.message,'success')
                }
                else {
                    new_show_notify_message_no_reload("Error",response.data.message,'error')
                }
                $("#create-btn").html("Create");
                $('#create-btn').prop('disabled', false);
            })
            .catch(function (error) {
                new_show_notify_message_no_reload("Error",'There was an error, please try again','error')
                $("#create-btn").html("Create");
                $('#create-btn').prop('disabled', false);
            })
        },
        createTicketOld: function() {
            var self = this

            

            axios.post(url, {
                subject: self.ticketTitle, 
                description: self.ticketDesc
            },
            {
                headers:
                {
                    "Authorization" : 'Bearer '+self.userToken
                }
            })
            .then(function (response) {
                if (response.data.message) {
                    $("#create-btn").html("<i class='fa fa-save'></i> Create");
                    $('#create-btn').prop('disabled', false);

                    self.ticketTitle       = ''
                    self.ticketDesc        = ''
                    self.ticketAttachment  = ''
                    self.noAttachment      = 'no'

                    new_show_notify_message_no_reload("Success",response.data.message,'success')
                }
                else {   
                    $("#create-btn").html("<i class='fa fa-save'></i> Create");
                    $('#create-btn').prop('disabled', false);
                    new_show_notify_message_no_reload("Error",response.data.message,'error')
                }
            })
            .catch(function (error) {
                $("#create-btn").html("<i class='fa fa-save'></i> Create");
                $('#create-btn').prop('disabled', false);
                new_show_notify_message_no_reload("Error",'There was an error, please try again','error')
                return false
            })
        },
        clearFields: function() {
            var self = this

            self.ticketTitle       = ''
            self.ticketReg         = ''
            self.ticketDesc        = ''
            self.ticketAttachment  = ''
            self.noAttachment      = 'no'
        }
        
    } //methods end
    
})