<template>
    <div>
        <div class="uk-margin">
            <a class="uk-button uk-button-primary" @click="addDomain()"><span class="uk-margin-small-right" uk-icon="icon: plus"></span> Add new</a>
        </div>
        <div class="d-inline">
            <h6>search:</h6>
            <input  class="w-50" type="text" placeholder="searchname" v-model="domainSearchName" v-on:keyup="searchDomain" v-bind:class="{ danger: domainSearchName.length < 4 }">
            <button @click="searchDomainClear()" class="btn btn-secondary">clear</button>
        </div>
        <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>

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


            <div class="" v-for="domain in domains" v-bind:key="domain.id">
                <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                    <div>
                        <div class="uk-grid-small uk-grid-divider" data-uk-grid>
                            <div class="uk-width-expand uk-flex-middle uk-flex">
                                <div>
                                    <span  :class="{ 'tm-label-stoped' : domain.state == null || domain.state == ''}" class="uk-label uk-margin-small-right">{{domain.state == null || domain.state == '' ? 'stoped' : domain.state}}</span>
                                    <a href="#" class="uk-link-text">{{ domain.name }}</a>
                                    <a :href="httpAdd(domain.link)" target="_blank" class="tm-margin-xsmall-left" data-uk-icon="icon: link;ratio: 0.8" data-uk-tooltip="www..."></a>
                                </div>
                            </div>
                            <div class="uk-width-auto">
                                <a @click="editdomain(domain)" v-scroll-to="{ el: '#domain-widget', offset: -70, }" class="" data-uk-icon="icon: cog;ratio: 0.8" data-uk-tooltip="Edit"></a>
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
        created() {
            this.fetchDomains();
        },
        methods:{
            httpAdd(url){
                if(url.indexOf('http://') > -1) {
                    return url;
                }  else {
                    return 'http://' + url;
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
                        console.log(res.data);
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
                this.$root.$emit ("domainData", domain);
            },
            forceRerender() {
                this.componentKey += 1;
            },
            searchDomainClear(){
                this.domainSearchName = '';
                this.fetchDomains();
                this.forceRerender();
            },
            searchDomain(searchName){
                if((this.domainSearchName).length >= 2 ){
                    console.log('change', this.domainSearchName);
                    let vm = this;
                    fetch('/api/domains', {
                            method: 'post',
                            body : JSON.stringify({paginate: this.paginate, paginateElements: 5 , searchDomain: this.domainSearchName}),
                            headers:{
                                'content-type':'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res =>{
                            //console.log(res.data);
                            this.domains = res.data;
                            if(this.paginate) vm.makePagination(res.meta, res.links);
                        })
                        .catch(err => console.log(err));
                }
            }
        },
    }
</script>

<style scoped>

</style>