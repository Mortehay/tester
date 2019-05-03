<template>
    <div>
        <form id="domain-editor" @submit.prevent="addDomain" class="uk-form">
            <div class="uk-grid-small uk-child-width-1-2@s" data-uk-grid>
                <div>
                    <input type="text" class="uk-input" placeholder="domain name" v-model="domain.name">
                </div>
                <div>
                     <input type="text" class="uk-input" placeholder="domain link" v-model="domain.link">
                </div>
                <div>
                     <input type="text" class="uk-input" placeholder="domain domaining_name" v-model="domain.hosting_name">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain domaining_link" v-model="domain.hosting_link">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain login" v-model="domain.login">
                </div>
                <div>
                    <input type="text" class="uk-input" placeholder="domain password" v-model="domain.password">
                </div>
                <div class="uk-width-1-1">
                     <textarea type="text" class="uk-input" placeholder="domain description" v-model="domain.description"></textarea>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-auto uk-grid">
                <div v-for="type in types">
                    <label>
                        <input v-on:click="typeChange" type="radio" class="uk-radio" :value="type.code"  v-model="domainType" > {{type.name}}
                    </label>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-margin" v-if="domain.screen">
                    <img :src="domain.screen" class="img-responsive" height="70" width="90">
                </div>
                <div uk-form-custom="target: true">
                    <input type="file" @change="screenChanged">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                </div>
            </div>
            <button type="submit" class="uk-button uk-button-primary">Save</button>
        </form>
        <div class="uk-margin">
            <nav aria-label="Page navigation example" id="page-navigation">
                <ul class="uk-pagination uk-flex-center" data-uk-margin>
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a href="#" @click="fetchDomains(pagination.prev_page_url)"><span uk-pagination-previous></span></a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a href="#" @click="fetchDomains(pagination.next_page_url)"><span uk-pagination-next></span></a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="" v-for="domain in domains" v-bind:key="domain.id">
            <div class="uk-margin">
                <div data-uk-grid>
                    <div class="uk-width-1-3@m">
                        <a class="uk-cover-container uk-transition-toggle uk-display-block uk-link-reset" :href="domain.link" target="_blank">
                            <img :src="domain.screen !== null ? location + '/' +domain.screen.image_path : ''" >
                            <div class="uk-overlay-primary uk-transition-fade uk-position-cover"></div>
                            <div class="uk-position-center">
                                <div class="uk-overlay uk-transition-fade uk-light">
                                    Visit web-site
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="uk-width-2-3@m">
                        <div class="uk-flex-middle uk-grid-small" data-uk-grid>
                            <div class="uk-text-bold uk-h4">
                                <a class="uk-link-reset" :href="domain.link" target="_blank">
                                    {{ domain.id }}. {{ domain.name }}
                                </a>
                            </div>
                            <div><a class="uk-link-muted" href="#" target="_blank">({{ domain.type }})</a></div>
                        </div>
                        <div class="uk-text-meta">
                            Additional domains: <a :href="domain.domaining_link" class="uk-link-muted" target="_blank">{{ domain.domaining_name }}</a>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-child-width-1-1 uk-grid-collapse" data-uk-grid>
                                <div>
                                    Login: {{ domain.login }}
                                </div>
                                <div>
                                    Password: {{ domain.password }}
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin">
                            {{ domain.description }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button @click="editdomain(domain)" class="uk-button uk-button-primary" v-scroll-to="{ el: '#domain-editor', offset: -70, }">edit</button>
                <button @click="deleteDomain(domain.id)" class="uk-button uk-button-danger" v-scroll-to="{el : '#page-navigation'}">delete</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "domains",
        data() {
            return {
                location: window.location.origin,
                domains: [],
                domainType: '',
                types:[
                        {
                            code: 'h_',
                            name:'host',
                        }, {
                            code: '_d',
                            name:'domain',
                        },
                        {
                            code:'hd',
                            name:'host+domain'
                        }
                    ],
                domain: {
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
                },
                domain_id: '',
                pagination: {},
                edit: false,
                validationErrors:[],

            };
        },
        created() {
            this.fetchDomains();
        },
        methods:{


            /*logoChanged(e){
                if(e.target.files[0] !== undefined){
                    if(this.validationErrors.logo != undefined) this.validationErrors.logo = false;
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domain.image = e.target.result
                    }
                    this.domain.logo = true;
                } else {
                    this.domain.image = false;
                }

                console.log(this.domain);
            },*/
            screenChanged(e){
                if(e.target.files[0] !== undefined){
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.domain.screen = e.target.result
                    }
                } else {
                    this.domain.screen = false;
                }

                console.log(this.domain);
            },
            typeChange(){
                let vm = this;
                let type = event.target.value;
                this.domain.type = event.target.value;
                //console.log(this.domain);
            },
            fetchDomains(page_url){
                let vm = this;

                page_url = page_url || '/api/domains';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        console.log(res.data);
                        this.domains = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page:meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                //console.log(pagination);
                this.pagination = pagination;
            },
            deleteDomain(id){
                if(confirm('are you sure?')){
                    fetch(`/api/domains/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('domain removed');
                            this.fetchDomains();
                        })
                        .catch(err =>console.log(err));
                }
            },
            addDomain(){
                //console.log(this.edit);
                //console.log(this.domain);
                if(this.edit === false){
                    //add
                    fetch('/api/domain',{
                        method: 'post',
                        body : JSON.stringify(this.domain),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.domain.name = '';
                            this.domain.link = '';
                            this.domain.domaining_name = '';
                            this.domain.domaining_link = '';
                            this.domain.type = '';
                            this.domain.login = '';
                            this.domain.password = '';
                            this.domain.description = '';
                            this.domain.screen = '',
                            alert('domain added');
                            this.fetchDomains();
                            this.$scrollTo('#page-navigation');
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    //console.log('update');
                    console.log(this.domain);

                    fetch('/api/domain',{
                        method: 'put',
                        body : JSON.stringify(this.domain),
                        headers:{

                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.edit = false;
                            this.domain = {
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
                            };
                            alert('domain updated');
                            this.fetchDomains();
                        })
                        .catch(err => console.log(err));

                }
                this.forceRerender();
            },
            editdomain(domain){
                this.edit = true;
                this.domain.id = domain.id;
                this.domain.domain_id = domain.id;
                this.domain.name = domain.name;
                this.domain.link = domain.link;
                this.domain.hosting_name = domain.hosting_name;
                this.domain.hosting_link = domain.hosting_link;
                this.domainType = domain.type;
                this.domain.type = domain.type;
                //console.log(domain.type);
                this.domain.screen = domain.screen != null ? domain.screen.image_path : '';
                this.domain.login = domain.login;
                this.domain.password = domain.password;
                this.domain.description = domain.description;


            },
            /*goToEmployees(domain){
                //this.$route.push({ path: `/domains/${domain.id}/employees` }) // -> /domains/1/employees
                window.location.href = `/tabledomains/${domain.id}/tableadditionaldomains`;
            },*/
            forceRerender() {
                this.componentKey += 1;
            }
        }
    }
</script>

<style scoped>

</style>