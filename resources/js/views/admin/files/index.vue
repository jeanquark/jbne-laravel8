<template>
    <div>
        <h1>Files</h1>
        data: {{ data }}<br /><br />
        data3: {{ data3 }}<br /><br />
        tree3: {{ tree3 }}<br /><br />
        <!-- <div v-for="(item, index) in data3" :key="index">{{ item }} <br /><br /></div> -->
        <!-- <br /><br /> -->
        <!-- entries3: {{ entries3 }}<br /><br /> -->
        <!-- items: {{ items }}<br /><br /> -->
        <!-- items2: {{ items2 }}<br /><br /> -->
        <!-- <a href="/images/1920x1080.jpg" download>Download image</a> -->
        <!-- <a href="/storage/app/files/768x600.jpg" download>Download image 2</a> -->

        <v-treeview v-model="tree3" :items="data3" activatable item-key="name" :return-object="false" open-on-click>
            <template v-slot:prepend="{ item, open }">
                <v-icon v-if="!item.file">
                    {{ open ? 'mdi-folder-open' : 'mdi-folder' }}
                </v-icon>
                <v-icon v-else>
                    {{ files[item.file] }}
                </v-icon>
            </template>
            <template v-slot:label="{ item }">
                <span v-if="item.file" class="file" @click="download(item)">
                    {{ item.name }}
                    <!--<v-btn small @click="download(item)">download</v-btn>-->
                </span>
                <span v-else>
                    {{ item.name }}
                </span>
            </template>
        </v-treeview>

        <br /><br />

        <h2>Folders:</h2>
        abc: {{ abc }}<br />
        <v-btn @click="navigateBack">Move back</v-btn>
        <div v-for="(item, index) in abc" :key="index" style="border: 1px solid red; cursor: pointer;" @click="navigate(index, item)">{{ item.name }} <br /><br /></div>
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
        this.data = data
        // console.log('parseInt(00): ', parseInt(00))
        for (let i = 0; i < data.length; i++) {
            // console.log("data[i]: ", data[i]);
            const separator = data[i].split('/')
            // console.log("separator: ", separator);
            let overrideParentId = false
            let newParentId
            for (let j = 0; j < separator.length; j++) {
                // console.log("overrideParentId: ", overrideParentId);
                let id = parseInt(`${j + 1}${i + 1}`)
                let file
                let parentId = overrideParentId ? newParentId : parseInt(`${j < 1 ? 0 : j}${j < 1 ? 0 : i + 1}`)
                let double = this.entries3.find((a) => a.name === separator[j] && a.parentId == parentId)
                if (double) {
                    // console.log("double: ", double);
                    overrideParentId = true
                    newParentId = double.id
                    // console.log("newParentId: ", newParentId);
                    continue
                }
                if (j >= separator.length - 1) {
                    // file = "pdf";
                    file = separator[j].split('.').pop()
                }
                this.entries3.push({
                    name: separator[j],
                    // level: j,
                    id: id.toString(),
                    parentId: parentId.toString(),
                    path: data[i],
                    file,
                    children: [],
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
            data3: [],
            // tree: [],
            tree3: [],
            entries3: [],
            files: {
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
                docx: 'mdi-file-word',
            },
            abc: []
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
        },
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
    },
}
</script>

<style scoped>
.file {
}
.file:hover {
    color: blue;
}
</style>
