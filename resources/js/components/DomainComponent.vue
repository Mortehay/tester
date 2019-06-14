<template>
    <div v-show="domainWidgetIsVisible" id="domain-widget" class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <div class="uk-h3 uk-margin-bottom" uk-grid>
            <div class="uk-width-1-2@s">
                {{domainParams.name}}
                <span class="uk-text-small">(edit mode)</span>
            </div>
            <div class="uk-margin uk-text-right uk-width-1-2@s">
                <button @click="addDomainParams(domainParams)" class="uk-button uk-button-small tm-button-save" data-uk-tooltip="Save">
                    <span class="tm-svg-top-fix" uk-icon="icon: check"></span>
                </button>
                <button class="uk-button uk-button-small uk-button-secondary" data-uk-tooltip="Stop">
                    <span class="tm-svg-top-fix" uk-icon="icon: arrow-down"></span>
                </button>
                <button class="uk-button uk-button-small uk-button-secondary" data-uk-tooltip="Start">
                    <span class="tm-svg-top-fix" uk-icon="icon: arrow-up"></span>
                </button>
                <button @click="deleteDomainParams(domainParams.id)" class="uk-button uk-button-small uk-button-danger" data-uk-tooltip="Delete">
                    <span class="tm-svg-top-fix" uk-icon="icon: trash"></span>
                </button>
                <button @click="clearDomainForm()" class="uk-button uk-button-small uk-button-primary" data-uk-tooltip="Cancel">
                    <span class="tm-svg-top-fix" uk-icon="icon: close"></span>
                </button>
            </div>
        </div>
        <form id="domainParams-editor" class="uk-form uk-form-stacked"><!--@submit.prevent="addDomainParams"-->
        <div class="uk-grid-small" data-uk-grid>
                <div class="uk-width-1-2@s">
                    <div class="uk-margin" v-if="domainParams.screen">
                        <img :src="(domainParams.screen).indexOf('data:image') > -1 ? domainParams.screen : location + '/' + domainParams.screen" class="img-responsive" height="70" width="90">
                    </div>
                    <div uk-form-custom="target: true">
                        <input type="file" @change="screenChanged">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                </div>
                <div class="uk-width-1-4@s">
                    <div class="uk-grid-small uk-child-width-1-1 uk-grid">
                        <div v-for="type in types">
                            <label>
                                <input v-on:click="radioOptionChange('type')" type="radio" class="uk-radio" :value="type.code"  v-model="domainParamsType" > {{type.name}}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-4@s">
                    <div class="uk-grid-small uk-child-width-1-1 uk-grid">
                        <div v-for="display in displayStatus">
                            <label>
                                <input v-on:click="radioOptionChange('display')" type="radio" class="uk-radio" :value="display.code"  v-model="domainParamsDisplay" > {{display.name}}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Site name</div>
                    <input type="text" class="uk-input" placeholder="Site name" v-model="domainParams.name">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Site link</div>
                    <input type="text" class="uk-input" placeholder="Site link" v-model="domainParams.link">
                </div>
                <div  class="uk-width-1-1@s">
                    <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                        <div class="uk-form-label uk-text-bold uk-text-left@s">Additional domain name</div>
                        <div class="uk-form-label uk-text-bold uk-text-left@s">Additional domain link</div>
                        <div></div>
                    </div>
                    <ul class="uk-list">
                        <li v-if="(domainParams.additionalDomains).length > 0" v-for="(additionaldomain, key) in domainParams.additionalDomains">
                            <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                                <div>
                                    <input type="text" class="uk-input uk-margin-small" :value="additionaldomain.name" v-on:blur= "textEditing=false; editText(key, $event.target.value, 'name')">
                                </div>
                                <div>
                                    <input type="text" class="uk-input uk-margin-small" :value="additionaldomain.link" v-on:blur= "textEditing=false; editText(key, $event.target.value, 'link')">
                                </div>
                                <div>
                                    <span style="color:red;" uk-icon="icon: minus-circle; ratio: 1" @click.prevent="deleteAddDomainParams(key, 'additionalDomains')"></span>
                                </div>
                            </div>
                        <li class="uk-margin-top">
                            <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                                <div>
                                    <input type="text" class="uk-input uk-margin-small" placeholder="Add domain name…"  v-model="additionalDomains.name">
                                </div>
                                <div>
                                    <input type="text" class="uk-input uk-margin-small" placeholder="Add domain link…"  v-model="additionalDomains.link">
                                </div>
                                <div>
                                    <span style="color:blue;" uk-icon="icon: plus-circle; ratio: 1" @click.prevent="newAdditioanalDomainParams(additionalDomains, 'additionalDomains')"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Hosing name</div>
                    <input type="text" class="uk-input" placeholder="Hosing name" v-model="domainParams.hosting_name">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Hosing link</div>
                    <input type="text" class="uk-input" placeholder="Hosing link" v-model="domainParams.hosting_link">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Login</div>
                    <input type="text" class="uk-input" placeholder="domainParams login" v-model="domainParams.login">
                </div>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Password</div>
                    <input type="text" class="uk-input" placeholder="domainParams password" v-model="domainParams.password">
                </div>
                <div class="uk-width-1-1">
                    <textarea type="text" class="uk-textarea" rows="5" placeholder="domainParams description" v-model="domainParams.description"></textarea>
                </div>
            </div>
            <div class="uk-hr"></div>

            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Monitor interval</div>
                    <div class="uk-grid-small  uk-grid">
                        <div v-for="timer in timers">
                            <label>
                                <input v-on:click="radioOptionChange('timer')" type="radio" class="uk-radio" :value="timer.code"  v-model="domainParamsTimer" > {{timer.name}} {{ $t('texts.timer.title')}}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-hr"></div>

            <div  class="uk-width-1-1@s">
                <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                    <div class="uk-form-label uk-text-bold uk-text-left@s">Additional alert mail</div>
                    <!--<div class="uk-form-label uk-text-bold uk-text-left@s">Additional domain link</div>-->
                    <div></div>
                </div>
                <ul class="uk-list">
                    <li v-if="(domainParams.additionalMails).length > 0" v-for="(additionalmail, key) in domainParams.additionalMails">
                        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                            <div>
                                <input type="text" class="uk-input uk-margin-small" :value="additionalmail.alert_mail" v-on:blur= "textEditing=false; editText(key, $event.target.value, 'alert_mail')">
                            </div>

                            <div>
                                <span style="color:red;" uk-icon="icon: minus-circle; ratio: 1" @click.prevent="deleteAddDomainParams(key, 'additionalMails')"></span>
                            </div>
                        </div>
                    <li class="uk-margin-top">
                        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                            <div>
                                <input type="text" class="uk-input uk-margin-small" placeholder="Add alert mail"  v-model="additionalMails.alert_mail">
                            </div>
                            <div>
                                <span style="color:blue;" uk-icon="icon: plus-circle; ratio: 1" @click.prevent="newAdditioanalDomainParams(additionalMails, 'additionalMails')"></span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-grid-small" data-uk-grid>
                <div class="uk-width-1-2@s">
                    <div class="uk-form-label uk-text-bold">Additional alert contact</div>
                    <input type="text" class="uk-input uk-margin-small" placeholder="email">
                    <input type="text" class="uk-input uk-margin-small" placeholder="email" id="my-id1" hidden>
                    <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small" uk-toggle="target: #my-id1; animation: uk-animation-fade">Add more</button>
                </div>
            </div>

        </form>

    </div>

</template>

<script>
    export default {
        name: "domain",
        props:{  },
        data() {
            return {
                location: window.location.origin,
                domainParams: [],
                domainParamsType: '',
                domainParamsDisplay: '',
                domainParamsTimer: '',
                types:[
                    {
                        code: 'h_',
                        name:'host',
                    },
                    {
                        code: '_d',
                        name:'domain',
                    },
                    {
                        code:'hd',
                        name:'host+domain'
                    }
                ],
                displayStatus:[
                    {
                        code: 'show',
                        name: 'show',
                    },
                    {
                        code: 'hide',
                        name: 'hide',
                    }
                ],
                timers:[
                    {
                        code: 5,
                        name: 5,
                    },
                    {
                        code: 15,
                        name: 15,
                    },
                    {
                        code: 30,
                        name: 30,
                    },
                    {
                        code: 60,
                        name: 60,
                    },
                ],
                editedText: null,
                textEditing: false,
                domainParams: {
                    id: '',
                    name: '',
                    link:'',
                    hosting_name: '',
                    hosting_link: '',
                    type: '',
                    login: '',
                    password: '',
                    description: '',
                    screen: '',
                    image: '',
                    display:'',
                    timer:'',
                    additionalDomains: [],
                    additionalMails: [],
                },
                additionalDomains: {},
                additionalMails: {},
                domain_id: '',
                pagination: {},
                edit: false,
                domainWidgetIsVisible: false,
                validationErrors:[],

            };
        },
        created() {


        },
        mounted() {
            this.$root.$on('domainData', (data) => {
                if(typeof data.domainWidgetIsVisible != undefined && data.domainWidgetIsVisible == false){
                    this.clearDomainForm();
                }
                if(typeof data.id != undefined) {
                    this.domainWidgetIsVisible = true;
                    this.edit = true;
                    this.domainParams.id = data.id;
                    this.domainParams.domain_id = data.id;
                    this.domainParams.name = data.name;
                    this.domainParams.link = data.link;
                    this.domainParams.hosting_name = data.hosting_name;
                    this.domainParams.hosting_link = data.hosting_link;
                    this.domainParamsType = data.type;
                    this.domainParamsDisplay = data.display;
                    this.domainParamsTimer = data.timer;
                    this.domainParams.type = data.type;
                    this.domainParams.display = data.display;
                    this.domainParams.timer = data.timer;
                    //console.log(domainParams.type);
                    this.domainParams.screen = data.screen;
                    this.domainParams.login = data.login;
                    this.domainParams.password = data.password;
                    this.domainParams.description = data.description;
                    this.domainParams.additionalDomains = data.additionalDomains;
                    this.domainParams.additionalMails = data.additionalMails;
                }
            })
        },
        methods:{
            editText: function(key, text, field) {
                //console.log(key, text);
                this.domainParams.additionalDomains[key].field = text;

            },
            newAdditioanalDomainParams(newdomainParams, paramName) {
                console.log('click');
                let state = true;
                let paramObject = {};
                Object.keys(newdomainParams).forEach(function(key) {
                    if(newdomainParams[key] == '') state = false;
                    paramObject[key] = newdomainParams[key];
                });
                if(state) {
                    this.domainParams[paramName].push(paramObject);
                    return this[paramName] = {};
                } else {
                    alert('pleas enter add domain params');
                }
            },
            newAdditioanalDomain(newdomainParams) {
                if(newdomainParams.name != '' && newdomainParams.link != ''){
                    this.domainParams.additionalDomains.push({name: newdomainParams.name , link: newdomainParams.link});
                    return this.newAdddomain = {name: '', link : ''};
                } else {
                    alert('pleas enter add domain params');
                }

            },
            deleteAddDomainParams(index, paramName){

                this.domainParams[paramName].splice(index,1);
                return false;
            },
            /*deleteAdditionalDomain(index) {
                this.domainParams.additionalDomains.splice(index, 1);
                return false;
            },*/
            screenChanged(e){
                if(e.target.files[0] !== undefined){
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domainParams.screen = e.target.result
                    }
                } else {
                    this.domainParams.screen = false;
                }

                console.log(this.domainParams);
            },
            httpAdd(url){
                if(url.indexOf('http://') > -1) {
                    return url;
                }  else {
                    return 'http://' + url;
                }
            },
            radioOptionChange(option){
                let vm = this;
                this.domainParams[option] = event.target.value;
                //console.log(this.domainParams);
            },
            /*typeChange(){
                let vm = this;
                let type = event.target.value;
                this.domainParams.type = event.target.value;
            },
            displayChange(){
                let vm = this;
                let display = event.target.value;
                this.domainParams.display = event.target.value;
            },*/
            deleteDomainParams(id){
                if(confirm('are you sure?')){
                    fetch(`/api/domain/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('domainParams removed');
                        })
                        .catch(err =>console.log(err));
                }
                this.clearDomainForm()
            },
            addDomainParams(){
                console.log(this.domainParams);
                if(this.edit === false){
                    //add
                    fetch('/api/domain',{
                        method: 'post',
                        body : JSON.stringify(this.domainParams),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.domainParams.name = '';
                            this.domainParams.link = '';
                            this.domainParams.domainParamsing_name = '';
                            this.domainParams.domainParamsing_link = '';
                            this.domainParams.type = '';
                            this.domainParams.display = '';
                            this.domainParams.login = '';
                            this.domainParams.password = '';
                            this.domainParams.description = '';
                            this.domainParams.screen = '';
                            this.domainParams.image = '';
                            this.domainParams.display = '';
                            this.domainParams.additionaldomainParams = [];
                            this.newAdddomainParams = '';
                            this.newAdddomain =  {name: '', link : ''};
                            alert('domainParams added');
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    //console.log('update');
                    //console.log(this.domainParams);

                    fetch('/api/domain',{
                        method: 'put',
                        body : JSON.stringify(this.domainParams),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.edit = false;
                            this.domainParams = {
                                id: '',
                                name: '',
                                link:'',
                                hosting_name: '',
                                hosting_link: '',
                                type: '',
                                login: '',
                                password: '',
                                description: '',
                                screen:'',
                                image: '',
                                display:'',
                                timer:'',
                                additionalDomains:[],
                                additionalMails:[],
                            };
                            this.newAdddomain = {name: '', link : ''};
                            alert('domain updated');
                        })
                        .catch(err => console.log(err));

                }
                this.$root.$emit ("domainList", {rerender: true});
                //this.forceRerender();
            },
            clearDomainForm(){
                this.edit = false;
                this.domainParams = {
                    id: '',
                    name: '',
                    link:'',
                    hosting_name: '',
                    hosting_link: '',
                    type: '',
                    login: '',
                    password: '',
                    description: '',
                    screen:'',
                    image: '',
                    display:'',
                    additionalDomains:[],
                };
                this.newAdddomain = {name: '', link : ''};
                this.domainWidgetIsVisible = false;
            },
            /*editdomainParams(domainParams){
                this.edit = true;
                this.domainParams.id = domainParams.id;
                this.domainParams.domain_id = domainParams.id;
                this.domainParams.name = domainParams.name;
                this.domainParams.link = domainParams.link;
                this.domainParams.hosting_name = domainParams.hosting_name;
                this.domainParams.hosting_link = domainParams.hosting_link;
                this.domainParamsType = domainParams.type;
                this.domainParams.type = domainParams.type;
                this.domainParamsDisplay = domainParams.display;
                this.domainParams.display = domainParams.display;
                //console.log(domainParams.type);
                this.domainParams.screen = domainParams.screen;
                this.domainParams.login = domainParams.login;
                this.domainParams.password = domainParams.password;
                this.domainParams.description = domainParams.description;
                this.domainParams.additionaldomainParams = domainParams.additionalDomains;

            },*/
            forceRerender() {
                this.componentKey += 1;
            }
        },
    }
</script>

<style scoped>

</style>