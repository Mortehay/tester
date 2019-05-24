<template>
    <div>
        <div class="uk-card-body">
            <div class="uk-margin">
                <div class="uk-flex-midlle" uk-grid>
                    <div class="uk-width-expand">
                        <a class="uk-button uk-button-primary" @click="addDomain()"><span class="uk-margin-small-right" uk-icon="icon: plus"></span> Add new</a>
                    </div>
                    <div class="uk-width-auto">
                        <a class="uk-button uk-button-primary tm-refresh-button" @click="fetchDomains()">
                            <span class="tm-svg-top-fix" uk-icon="icon: refresh"></span>
                        </a>
                    </div>
                </div>

            </div>
            <div class="uk-margin">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand">
                        <div class="uk-inline uk-width-1-1">
                            <span class="uk-form-icon" uk-icon="icon: search"></span>
                            <input  class="uk-input uk-width-1-1" type="text" placeholder="search" v-model="domainSearchName" v-on:keyup="searchDomain" v-bind:class="{ danger: domainSearchName.length < 4 }">
                        </div>
                    </div>
                    <div class="uk-width-auto">
                        <button @click="searchDomainClear()" class="uk-button uk-button-primary tm-refresh-button tm-button-default">
                            <span class="tm-svg-top-fix" uk-icon="icon: close"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="uk-grid-small tm-padding-bottom uk-child-width-1-1" data-uk-grid>
            <div v-if="paginate" class="uk-margin">
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
            <div v-for="domain in domains" v-bind:key="domain.id">
                <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                    <div>
                        <div class="tm-list-hover">
                            <div class="uk-grid-small uk-grid-divider" data-uk-grid>
                                <div class="uk-width-expand uk-flex-middle uk-flex">
                                    <div class="uk-flex-middle uk-flex">
                                        <span  :class="{ 'tm-label-stoped' : domain.state == null || domain.state == ''}" class="uk-label uk-margin-small-right">{{domain.state == null || domain.state == '' ? 'stoped' : domain.state}}</span>
                                        <a @click="editdomain(domain)" v-scroll-to="{ el: '#domain-widget', offset: -70, }" class="uk-link-text">{{ domain.name }}</a>
                                        <a :href="httpAdd(domain.link)" target="_blank" class="tm-margin-xsmall-left" data-uk-icon="icon: link;ratio: 0.8" data-uk-tooltip="www..."></a>
                                    </div>
                                </div>
                                <div class="uk-width-auto uk-flex-middle">
                                    <a @click="editdomain(domain)" v-scroll-to="{ el: '#domain-widget', offset: -70, }" class="uk-link-heading" data-uk-tooltip="Edit">
                                        <span class="tm-svg-top-fix" uk-icon="icon: cog;ratio: 1"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "domains",
        components:{  },
        props: {},
        data() {
            return {
                rerender: false,
                domainListKey: 0,
                paginate: false,
                location: window.location.origin,
                domains: [],
                domainSearchName: '',
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
                    additionalDomains: [],
                    state: '',
                    isOpen: false,
                },
                pagination: {},
                validationErrors:[],
            };
        },
        beforeMount() {
            this.$root.$on('domainList', (data) => {
                this.rerender = data.rerender;
            })
        },
        watch:{
          rerender: function(val) {

              if(this.rerender) {

                  this.fetchDomains();
                  this.rerender = false;
              }

          }
        },
        created() {
            this.fetchDomains();
        },
        methods:{
            httpAdd(url){
                if(url != null && (typeof url != undefined) &&  url.indexOf('http://') > -1 ) {
                    return url;
                }  else if(url != null) {
                    return 'http://' + url;
                } else {
                    return 'javascript:void(0);'
                }
            },
            fetchDomains(page_url){
                let vm = this;

                page_url = page_url || '/api/domains';
                fetch(page_url, {
                        method: 'post',
                        body : JSON.stringify({paginate: this.paginate, paginateElements: 5 }),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res =>{
                        //console.log(res.data);
                        this.domains = res.data;
                        console.log(this.domains);
                        if(this.paginate) vm.makePagination(res.meta, res.links);
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
            addDomain(){
                this.$root.$emit ("domainData",
                    {
                        id: '',
                        name: '',
                        link:'',
                        hosting_name: '',
                        hosting_link: '',
                        type: '',
                        display: '',
                        login: '',
                        password: '',
                        description: '',
                        screen:'',
                        additionalDomains:[],
                        state: '',
                    }
                );
            },
            editdomain(domain){
                this.$root.$emit ("domainData", {
                    id: domain.id,
                    name: domain.name,
                    link: domain.link,
                    hosting_name: domain.hosting_name,
                    hosting_link: domain.hosting_link,
                    type: domain.type,
                    login: domain.login,
                    password: domain.password,
                    description: domain.description,
                    screen: (typeof domain.screen != undefined) && domain.screen.image_path != null ? domain.screen.image_path : 'storage/test.jpg',
                    additionalDomains: domain.additionalDomains,
                    state: domain.state,
                    display: domain.display != '' && domain.display != null ? domain.display : 'hide',
                });
            },
            forceRerender(key) {
                this[key] += 1;
            },
            searchDomainClear(){
                this.domainSearchName = '';
                this.fetchDomains();
                this.forceRerender('domainListKey');
                this.$root.$emit ("domainData", {
                    domainWidgetIsVisible: false,
                });
            },
            searchDomain(searchName){
                let params = {
                    method: 'post',
                    headers:{
                        'content-type':'application/json'
                    }
                };
                if((this.domainSearchName).length >= 2 ){
                    params['body'] = JSON.stringify({paginate: this.paginate, paginateElements: 5 , searchDomain: this.domainSearchName});
                    //console.log('change', this.domainSearchName);

                } else {
                    params['body'] = JSON.stringify({paginate: this.paginate, paginateElements: 5 });
                }
                let vm = this;
                fetch('/api/domains', params)
                    .then(res => res.json())
                    .then(res =>{
                        //console.log(res.data);
                        this.domains = res.data;
                        if(this.paginate) vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            }
        },
    }
</script>

<style scoped>

</style>