<template>
    <div>
        <h1>Files</h1>
        data: {{ data }}<br /><br />
        directories: {{ directories }}<br /><br />
        files: {{ files }}<br /><br />
        directoriesList: {{ directoriesList }}<br /><br />
        data3: {{ data3 }}<br /><br />
        <!-- <div v-for="(item, index) in data3" :key="index"> {{ index }} -- {{ item }} <br /><br /></div><br /><br /> -->
        data4: {{ data4 }}<br /><br />
        selection: {{ selection }}<br /><br />
        selectedParents: {{ selectedParents }}<br /><br />
        opened: {{ opened }}<br /><br />
        <!-- <br /><br /> -->
        <!-- entries3: {{ entries3 }}<br /><br /> -->
        <!-- def: {{ def }}<br /><br /> -->
        <!-- items: {{ items }}<br /><br /> -->
        <!-- items2: {{ items2 }}<br /><br /> -->
        <!-- <a href="/images/1920x1080.jpg" download>Download image</a> -->
        <!-- <a href="/storage/app/files/768x600.jpg" download>Download image 2</a> -->

        <!-- <v-treeview :items="items" item-key="id" :open="[1]" @update:open="navigateTo2"></v-treeview> -->

        <!-- <br /><br /> -->

        <!-- <v-treeview :items="data3" item-key="name" :return-object="true" :hoverable="true" :activatable="false" :open-on-click="true" :multiple-active="false" @update:open="navigateTo" v-model="selection"> -->
        <v-treeview :items="data3" item-key="name" :return-object="true" :hoverable="true" :open-on-click="true" :multiple-active="false" :activatable="false" @update:open="navigateTo" @update:active="updateActive">
            <template v-slot:prepend="{ item, open }">
                <v-icon @click="navigateTo3(item, open)" v-if="!item.file" style="border: 1px solid red;">
                    {{ open ? 'mdi-folder-open' : 'mdi-folder' }}
                </v-icon>
                <v-icon v-else>
                    {{ fileTypes[item.file] }}
                </v-icon>
            </template>
            <template v-slot:label="{ item, open }">
                <span v-if="item.file" class="file" @click="download(item)">
                    {{ item.name }}
                </span>
                <span @click="navigateTo3(item, open)" style="border: 1px dashed green;" v-else>
                    {{ item.name }}
                </span>
            </template>
        </v-treeview>

        <br /><br />
        <h2>abc3:</h2>
        {{ abc3 }}
        <!-- <div v-for="(item, index) in abc3" :key="index" style="border: 1px solid red; cursor: pointer" @click="navigate(index, item)">{{ item.name }} <br /><br /></div> -->

        <br /><br />

        <h2>Folders:</h2>
        abc: {{ abc }}<br />
        <v-btn @click="navigateBack">Move back</v-btn>
        <div v-for="(item, index) in abc" :key="index" style="border: 1px solid red; cursor: pointer" @click="navigate(index, item)">{{ item.name }} <br /><br /></div>
    </div>
</template>

<script>
// var fileDownload = require('js-file-download');
import fileDownload from 'js-file-download'
export default {
    name: 'AdminFilesIndex',
    async created() {
        const data = await this.$store.dispatch('files/fetchFiles')
        // console.log("data: ", data);
        this.directories = data['directories']
        this.files = data['files']
        this.data = data['files']
        // console.log('parseInt(00): ', parseInt(00))
        for (let i = 0; i < this.directories.length; i++) {
            const separator = this.directories[i].split('/')
            console.log('separator: ', separator)
            if (!this.directoriesList[separator[separator.length - 1]]) {
                this.directoriesList[`${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id: i + 1,
                    parentId: this.directoriesList[separator[separator.length - 2]] ? this.directoriesList[separator[separator.length - 2]]['id'] : 0,
                    children: []
                }
            }
            if (separator[separator.length - 2]) {
                this.directoriesList[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
            }
            
            let parent
            if (separator.length == 1) {
                this.data4.push({
                    name: this.directoriesList[separator]['name'],
                    id: this.directoriesList[separator]['id'],
                    parentId: this.directoriesList[separator]['parentId'],
                    children: []
                })
            } else {
                const parentIndex = this.data4.findIndex(folder => folder.name == separator[separator.length - 2])
                console.log('parentIndex: ', parentIndex)
                // this.data4[parentIndex]['children'].push({
                //     name: 'abc'
                // })
            }
        }

        for (let i = 0; i < this.files.length; i++) {
            // console.log("data[i]: ", data[i]);
            const separator = this.files[i].split('/')
            // console.log("separator[separator.length - 1]: ", separator[separator.length - 1])
            if (separator[separator.length - 2]) {
                // console.log('abc')
                this.directoriesList[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
            } else {
                // console.log('root file')
                this.directoriesList[separator[separator.length - 1]] = {
                    name: separator[separator.length - 1]
                }
            }
            let overrideParentId = false
            let newParentId

            for (let j = 0; j < separator.length; j++) {
                // console.log("separator[j]: ", separator[j])
                // console.log("separator[j+1]: ", separator[j+1])
                if (this.directoriesList[separator[j]]) {
                    // console.log('file: ', this.directoriesList[separator[j]])
                    // console.log('file id: ', this.directoriesList[separator[j]]['id'])
                }
                if (separator[j - 1]) {
                    // console.log('file name: ', separator[j])
                    // console.log('parentId: ', this.directoriesList[separator[j - 1]]['id'])
                }
                // console.log(`File ${separator[j]} has an id of ${this.directoriesList[separator[j]] ? this.directoriesList[separator[j]]['id'] : null} and a parentId of ${separator[j - 1] ? this.directoriesList[separator[j - 1]]['id'] : 0}`)
                let id = parseInt(`${j + 1}${i + 1}`)
                let parentId = overrideParentId ? newParentId : parseInt(`${j < 1 ? 0 : j}${j < 1 ? 0 : i + 1}`)

                id = this.directoriesList[separator[j]] && this.directoriesList[separator[j]]['id'] ? this.directoriesList[separator[j]]['id'] : 0
                parentId = separator[j - 1] ? this.directoriesList[separator[j - 1]]['id'] : 0
                let parentName = separator[j-1] ? separator[j-1] : null
                let file



                // if (!this.def[`${parentId}_${separator[j]}`]) {
                // this.def.find()
                // console.log('Created ', parentId, separator[j])

                // this.def[`${parentId}_${id}`] = {
                //     name: separator[j],
                //     parentId,
                //     id,
                //     children: [separator[j + 1] ? separator[j + 1] : '']
                // }

                // this.def[`${parentId}_${id}`]['children'] ? this.def[`${parentId}_${id}`]['children'].push(separator[j+1]) : this.def[`${parentId}_${id}`]['children'] = []
                // } else {
                //     console.log('Already exists ', separator[j+1])
                //     this.def[`${parentId}_${separator[j]}`]['children'].push(separator[j+1])
                // }

                let duplicate = this.entries3.find(a => a.name === separator[j] && a.parentId == parentId)
                if (duplicate) {
                    // console.log("duplicate: ", duplicate);
                    overrideParentId = true
                    newParentId = duplicate.id
                    // console.log("newParentId: ", newParentId);
                    continue
                }
                // console.log("separator[j]: ", separator[j])
                if (j >= separator.length - 1) {
                    // file = "pdf";
                    file = separator[j].split('.').pop()
                }
                this.entries3.push({
                    name: separator[j],
                    id: id.toString(),
                    // id,
                    parentId: parentId.toString(),
                    // parentId,
                    parentName,
                    path: this.files[i],
                    file,
                    children: []
                })
                overrideParentId = false
                // console.log(`separator[j]: ${separator[j]} j: ${j}`);
            }
        }
        try {
            this.data3 = this.listToTree(this.entries3)
            this.abc = this.listToTree(this.entries3)
        } catch (error) {
            console.log('error: ', error)
        }
    },
    mounted() {},
    data() {
        return {
            data: null,
            expanded: true,
            opened: [],
            directories: [],
            files: [],
            directoriesList: {},
            selectedParents: [],
            data3: [],
            data4: [],
            // tree: [],
            selection: [],
            entries3: [],
            def: {},
            def2: {
                '0_11': {
                    name: 'Folder 1',
                    parentId: 0,
                    id: 11,
                    children: ['file_1.pdf']
                },
                '0_12': {
                    name: 'Folder 2',
                    parentId: 0,
                    id: 12,
                    children: ['Folder 2_1', 'Folder 2_2']
                },
                '0_16': {
                    name: 'Webstamps.pdf',
                    parentId: 0,
                    id: 16,
                    children: []
                },
                '12_22': {
                    name: 'Folder 2_1',
                    parentId: 12,
                    id: 22,
                    children: ['Folder 2_1_1', 'Folder 2_1_2', 'file 2_1.pdf']
                },
                '12_25': {
                    name: 'Folder 2_1',
                    parentId: 12,
                    id: 25,
                    children: ['file 2_2.pdf']
                },
                '22_33': {
                    name: 'Folder 2_1_1',
                    parentId: 22,
                    id: 33,
                    children: ['file 2_1_1.pdf']
                },
                '22_34': {
                    name: 'Folder 2_1_2',
                    parentId: 22,
                    id: 34,
                    children: ['file 2_1_2.pdf']
                }
            },
            fileTypes: {
                html: 'mdi-language-html5',
                js: 'mdi-nodejs',
                json: 'mdi-code-json',
                md: 'mdi-language-markdown',
                pdf: 'mdi-file-pdf',
                jpg: 'mdi-file-image',
                jpeg: 'mdi-file-image',
                png: 'mdi-file-image',
                txt: 'mdi-file-document-outline',
                xls: 'mdi-file-excel',
                doc: 'mdi-file-word',
                docx: 'mdi-file-word'
            },
            abc: [],
            abc3: [],
            items: [
                {
                    id: 1,
                    name: 'Applications :',
                    children: [
                        { id: 2, name: 'Calendar : app' },
                        { id: 3, name: 'Chrome : app' },
                        { id: 4, name: 'Webstorm : app' }
                    ]
                },
                {
                    id: 5,
                    name: 'Documents :',
                    children: [
                        {
                            id: 6,
                            name: 'vuetify :',
                            children: [
                                {
                                    id: 7,
                                    name: 'src :',
                                    children: [
                                        { id: 8, name: 'index : ts' },
                                        { id: 9, name: 'bootstrap : ts' }
                                    ]
                                }
                            ]
                        },
                        {
                            id: 10,
                            name: 'material2 :',
                            children: [
                                {
                                    id: 11,
                                    name: 'src :',
                                    children: [
                                        { id: 12, name: 'v-btn : ts' },
                                        { id: 13, name: 'v-card : ts' },
                                        { id: 14, name: 'v-window : ts' }
                                    ]
                                }
                            ]
                        }
                    ]
                },
                {
                    id: 15,
                    name: 'Downloads :',
                    children: [
                        { id: 16, name: 'October : pdf' },
                        { id: 17, name: 'November : pdf' },
                        { id: 18, name: 'Tutorial : html' }
                    ]
                },
                {
                    id: 19,
                    name: 'Videos :',
                    children: [
                        {
                            id: 20,
                            name: 'Tutorials :',
                            children: [
                                { id: 21, name: 'Basic layouts : mp4' },
                                { id: 22, name: 'Advanced techniques : mp4' },
                                { id: 23, name: 'All about app : dir' }
                            ]
                        },
                        { id: 24, name: 'Intro : mov' },
                        { id: 25, name: 'Conference introduction : avi' }
                    ]
                }
            ]
        }
    },
    computed: {
        abc2() {
            return this.data3
            // return this.data3.map(function (x) {
            //     return x.name
            // })
            // return this.data3[0]['children'].map(function (x) {
            //     return x.name
            // })
        }
    },
    methods: {
        listToTree(list) {
            var map = {},
                node,
                roots = [],
                i

            for (i = 0; i < list.length; i += 1) {
                map[list[i].id] = i // initialize the map
                list[i].children = [] // initialize the children
            }

            for (i = 0; i < list.length; i += 1) {
                node = list[i]
                if (node.parentId !== '0') {
                    // if you have dangling branches check that map[node.parentId] exists
                    list[map[node.parentId]].children.push(node)
                } else {
                    roots.push(node)
                }
            }
            return roots
        },
        navigate(index, item) {
            console.log('navigate: ', index, item)
            // this.abc = this.abc[1]['children'][0]['children']
            this.abc = this.abc[index]['children']
        },
        navigateBack() {
            console.log('navigateBack')
            this.abc = this.listToTree(this.entries3)
        },
        navigateTo(items) {
            console.log('navigateTo: ', items)
            // this.abc3 = this.def['0_Folder 1']
            // this.abc3 = 'abc3'
            console.log('last opened folder: ', items[items.length - 1]['name'])
            return
            // this.abc3 = this.data3.map(a => a.name)
            if (items && items.length > 0) {
                const currentDirectory = items[items.length - 1]
                console.log('currentDirectory.name: ', currentDirectory.name)
                console.log('currentDirectory: ', currentDirectory)
                // this.abc3 = this.def[`${currentDirectory.parentId}_${currentDirectory.id}`]['children']
                this.abc3 = this.directoriesList[`${currentDirectory.name}`]['children']
                // const abc = this.data3.flatMap((a) => a.children)
                // const abc = this.data3.find((product) => {
                //     return product.children.some((item) => {
                //         return item.name === 'Folder 2_2'
                //     })
                // })
                // let abc = []
                // let findDeep = function (data, activity) {
                //     return data.some(function (e) {
                //         if (e.name == activity) {
                //             abc.push(data)
                //         } else if (e.children) return findDeep(e.children, activity)
                //     })
                // }
                // console.log(findDeep(this.data3, currentDirectory.name))

                // const abc = this.data3.find(a => a.name == 'Folder 2_2' && a.parentId == 22)
                // console.log('abc: ', abc)
                // this.abc3 = ['abc', 'def', 'ghi']
                // this.abc3 = this.data3[1]['children'][0]['children']
            } else {
                // this.abc3 = []
                this.abc3 = this.data3.map(a => a.name)
            }
        },
        navigateTo2(items) {
            console.log('navigateTo2: ', items)
        },
        navigateTo3(item, open) {
            console.log('navigateTo3: ', item, open)
            console.log('item.name: ', item.name)
            if (item && open == false) {
                console.log('Move to children')
                const currentDirectory = item.name
                console.log('currentDirectory: ', currentDirectory)
                this.abc3 = this.directoriesList[`${currentDirectory}`]['children']
            } else if (item.parentName) {
                console.log('Move to parent')
                this.abc3 = this.directoriesList[item.parentName]['children']
            } else {
                console.log('Move to root')
                this.abc3 = this.data3.map(a => a.name)
            }
        },
        fetch2 () {
            console.log('fetch')
        },
        async download(file) {
            try {
                console.log('download file: ', file)
                const filePath = encodeURI(file.path)
                const data = await this.$store.dispatch('files/fetchFile', { filePath })
                fileDownload(data.data, file.name)
            } catch (error) {
                console.log('error: ', error)
                alert('Sorry, an error occured when trying to download file.')
            }
        },
        onOpen () {
            console.log('onOpen')
        },
        updateActive () {
            console.log('updateActive')
        }
    }
    // watch: {
    //     tree3(newValue) {
    //         console.log('[watch] tree3: ', newValue)
    //     },
    // },
}
</script>

<style scoped>
.file {
}
.file:hover {
    color: blue;
}
</style>
