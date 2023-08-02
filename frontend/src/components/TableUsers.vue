 <template>
    <div>
        <Card noborder>
            <div class="flex flex-row gap-5 mb-5">
                <SplitDropdown
                    classMenuItems="left-0  w-[220px] top-[110%] "
                    label="All Users"
                    labelClass="btn-light h-[50px]"
                    >
                </SplitDropdown>
                <h5 class="basis-1/4"></h5>
                <div class="basis-3/4 flex flex-row-reverse gap-5">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                             merged  classInput="h-[50px]"/>
                    <Button text="Create User" btnClass="btn-primary btn-xs float-right h-[50px]" link="/app/create-user" />
                </div>
            </div>
            <template v-if="all_users">
                     <vue-good-table :columns="columns" styleClass=" vgt-table bordered centered" :rows="all_users"
                         :pagination-options="{
                             enabled: true,
                             perPage: perpage,
                         }" :search-options="{
                                    enabled: true,
                                    externalQuery: searchTerm,
                                }" :select-options="{
                                    enabled: true,
                                    selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                                    selectioninfoClass: 'custom-class',
                                    selectionText: 'rows selected',
                                    clearSelectionText: 'clear',
                                    disableSelectinfo: true, // disable the select info-500 panel on top
                                    selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
                                }">
                         <template v-slot:table-row="props">
                             <span v-if="props.column.field == 'name'" class="flex">
                                 <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                     <img :src="user3" :alt="props.row.name"
                                    class="object-cover w-full h-full rounded-full" />
                                 </span>
                                 <span class="text-sm text-slate-600 dark:text-slate-300 capitalize">{{ props.row.name
                                 }}</span>
                             </span>
                             <span v-if="props.column.field == 'phone'">
                                 {{ props.row.country_code + "" + props.row.phone }}
                             </span>
                             <span v-if="props.column.field == 'account_number'" class="text-slate-500 dark:text-slate-300">
                                 {{ props.row.account_details.account_number }}
                             </span>
                             <span v-if="props.column.field == 'status'" class="block w-full">
                                 <span class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                     :class="`${props.row.status === 'active'
                                         ? 'text-success-500 bg-success-500'
                                         : ''
                                         } 
                                                                                     ${props.row.status === 'pending'
                                             ? 'text-warning-500 bg-warning-500'
                                             : ''
                                         }
                                                                                     ${props.row.status === 'not_active'
                                             ? 'text-danger-500 bg-danger-500'
                                             : ''
                                         }
                                                `">
                                     {{ props.row.status }}
                                 </span>
                             </span>
                             <span v-if="props.column.field == 'action'">
                                 <Dropdown classMenuItems=" w-[140px]">
                                     <span class="text-xl">
                                         <Icon icon="heroicons-outline:dots-vertical" />
                                     </span>
                                     <template v-slot:menus>
                                         <MenuItem v-for="(item, i) in actions" :key="i">
                                         <div  @click="item.doit(props.row.id)" :class="`${item.name === 'delete' ? 'bg-danger-500 text-danger-500 bg-opacity-30   hover:bg-opacity-100 hover:text-white'
                                             : 'hover:bg-slate-900 hover:text-white dark:hover:bg-slate-600 dark:hover:bg-opacity-50'}
                                                    w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                             <span class="text-base">
                                                 <Icon :icon="item.icon" />
                                             </span>
                                             <span>{{ item.name }}</span>
                                         </div>
                                         </MenuItem>
                                     </template>
                                 </Dropdown>
                             </span>
                         </template>
                         <template #pagination-bottom="props">
                             <div class="py-4 px-3">
                                 <Pagination :total="all_users.length" :current="current" :per-page="perpage" :pageRange="pageRange"
                                     @page-changed="current = $event" :pageChanged="props.pageChanged"
                                     :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                     >
                                 </Pagination>
                             </div>
                         </template>
                     </vue-good-table>
            </template>

        </Card>
    </div>
</template>
<script>
import Dropdown from "@/components/Dropdown";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import Pagination from "@/components/Pagination";
import { MenuItem } from "@headlessui/vue";
import { users } from "@/constant/basic-tablle-data";
import Button from "@/components/Button";
import SplitDropdown from '@/components/Dropdown/SplitDropdown';
import axios from "axios";
import { useToast } from "vue-toastification";
import user3 from "@/assets/images/users/default.jpg"

export default {
    components: {
        Pagination,
        SplitDropdown,
        InputGroup,
        Dropdown,
        Button,
        Icon,
        Card,
        MenuItem,
    },
    mounted() {
        this.fetchUsers()
        const toast = useToast();
    },
    methods: {
        async fetchUsers() {
            const data =  await axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/all_user`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // console.log(response.data.users)
                    useToast().success("User Fetch successfully", {
                        timeout: 2000,
                    });
                    return response.data?.users
                    
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            });
            this.all_users = data
        }
    },
    data() {
        return {
            user3,
            users,
            all_users: "",
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            actions: [
                {
                    name: "view",
                    icon: "heroicons-outline:eye",
                    doit: (id) => {
                        this.$router.push("/app/user/"+ id);
                    },
                },
                {
                    name: "edit",
                    icon: "heroicons:pencil-square",
                    doit: (id) => {
                        this.$router.push("/app/user/"+id+"/edit");
                    },
                },
                {
                    name: "delete",
                    icon: "heroicons-outline:trash",
                     doit: () => {
                        console.log("deleted")
                    },
                },
            ],
            options: [
                {
                    value: "1",
                    label: "1",
                },
                {
                    value: "3",
                    label: "3",
                },
                {
                    value: "5",
                    label: "5",
                },
            ],
            columns: [
                {
                    label: "User Ref",
                    field: "id",
                },
                {
                    label: "Name",
                    field: "name",
                },
                {
                    label: "AC Number",
                    field: "account_number",
                },
                {
                    label: "Email",
                    field: "email",
                },
                {
                    label: "Phone",
                    field: "phone",
                },

                {
                    label: "Account Status",
                    field: "status",
                },

                // {
                //     label: "Account Verified",
                //     field: "status",
                // },

                // {
                //     label: "Email Verified",
                //     field: "status",
                // },
                {
                    label: "Action",
                    field: "action",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
