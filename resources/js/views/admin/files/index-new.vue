<template>
    <div>
        <h1>Files</h1>
        directories: {{ directories }}<br /><br />
        files: {{ files }}<br /><br />
        directoriesObject: {{ directoriesObject }}<br /><br />
        directoriesObjectById: {{ directoriesObjectById }}<br /><br />
        directoriesArray: {{ directoriesArray }}<br /><br />
        <!-- filesArray: {{ filesArray }}<br /><br /> -->
        filesObject: {{ filesObject }}<br /><br />
        items: {{ items }}<br /><br />
        rootFolder: {{ rootFolder }}<br /><br />
        directoriesObject:<br />
        <!-- <div v-for="(item, index) in directoriesObject" :key="index">{{ index }} --- {{ item }} <br /><br /></div> -->
        <br /><br />
        currentFolder: {{ currentFolder }}<br />
        opened: {{ opened }}<br />
        difference: {{ difference }}<br />
        goTo: {{ goTo }}<br />
        <v-row no-gutters>
            <v-col cols="4" style="border: 1px solid orange">
                <v-treeview shaped hoverable open-on-click return-object :items="items" item-key="name" @update:open="updateOpen">
                    <template v-slot:label="{ item }">
                        <span v-if="item.file" class="file" @click="download(item)">
                            {{ item.name }}
                        </span>
                        <span style="border: 1px dashed green" v-else>
                            {{ item.name }}
                        </span>
                    </template>
                </v-treeview>
            </v-col>
            <v-col cols="8" style="border: 1px solid purple">
                <v-btn small @click="navigateBack" v-if="currentFolder">&larr; Back</v-btn>
                <span v-if="currentFolder">Content of {{ currentFolder['name'] }}:</span>
                <span v-else>Content of root</span>
                <div class="item" v-if="currentFolder">
                    <div style="border: 1px solid red; margin: 10px" v-for="(item, index) in currentFolder.children" :key="index" @click="selectFolder(item)">{{ item }}</div>
                </div>
                <div class="item" v-else>
                    <div style="border: 1px dashed blue; margin: 10px" v-for="(item, index) in rootFolder" :key="index" @click="selectFolder(item)">{{ item }}</div>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import fileDownload from 'js-file-download'
export default {
    name: 'AdminFilesIndex',
    async created() {
        const data = await this.$store.dispatch('files/fetchFiles')
        // console.log("data: ", data);
        this.directories = data['directories']
        this.files = data['files']

        let separator
        let index = 0
        // Loop through directories
        for (let i = 0; i < this.directories.length; i++) {
            separator = this.directories[i].split('/')
            // console.log('separator: ', separator)
            if (!this.directoriesObject[separator[separator.length - 1]]) {
                this.directoriesObject[`${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id: i + 1,
                    parentId: this.directoriesObject[separator[separator.length - 2]] ? this.directoriesObject[separator[separator.length - 2]]['id'] : 0,
                    children: [],
                }
                index++
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: i + 1,
                    parentId: this.directoriesObject[separator[separator.length - 2]] ? this.directoriesObject[separator[separator.length - 2]]['id'] : 0,
                    // children: []
                })
            }
            if (separator[separator.length - 2]) {
                this.directoriesObject[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
            }
        }

        // Loop through files
        for (let i = 0; i < this.files.length; i++) {
            separator = this.files[i].split('/')
            this.filesObject[separator[separator.length - 1]] = {
                name: separator[separator.length - 1],
                path: this.files[i]
            }
            if (separator[separator.length - 2]) {
                this.directoriesObject[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: index + 1,
                    // parentId: this.directoriesObject[separator[separator.length - 1]]
                    parentId: this.directoriesObject[separator[separator.length - 2]]['id'],
                    path: this.files[i],
                    file: true,
                })
            } else {
                this.directoriesObject[separator[separator.length - 1]] = {
                    name: separator[separator.length - 1],
                    id: index + 1,
                    parentId: 0,
                    file: true,
                }
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: index + 1,
                    parentId: 0,
                    path: this.files[i],
                    file: true,
                })
            }
            index++
        }

        // Create nested array
        this.items = this.listToTree(this.directoriesArray)
    },
    mounted() {},
    data() {
        return {
            directories: [],
            files: [],
            directoriesObject: {},
            directoriesObjectById: {},
            directoriesArray: [],
            // filesArray: [],
            filesObject: {},
            currentFolder: null,
            items: [],
            active: [],
            opened: [],
            selectedItem: null,
            difference: null,
            goTo: null,
        }
    },
    computed: {
        rootFolder() {
            return this.items.map((a) => a.name)
        },
    },
    methods: {
        updateOpen(items) {
            console.log('updateOpen items: ', items)
            // console.log('opened: ', this.opened)
            console.log('abc: ', items[items.length - 1])
            if (this.opened.length > 0) {
                this.difference = this.opened.filter((x) => !items.map((item) => item.name).includes(x))[0]
            }
            this.opened = items.map((item) => item.name)
            if (this.difference) {
                // this.goTo = this.difference + ' parent'
                // this.currentFolder = this.directoriesObject[this.difference]
                const parentId = this.directoriesObject[this.difference]['parentId']
                console.log('parentId : ', parentId)
                if (parentId != 0) {
                    const parentFolder = this.directoriesArray.find((x) => x.id == parentId)
                    this.goTo = parentFolder['name']
                    this.currentFolder = this.directoriesObject[this.goTo]
                } else {
                    this.goTo = null
                    this.currentFolder = null
                }
                console.log('goTo: ', this.goTo)
                this.difference = null
            } else {
                this.goTo = this.opened[this.opened.length - 1]
                this.currentFolder = this.directoriesObject[this.goTo]
            }
        },
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
                if (node.parentId !== 0) {
                    // if you have dangling branches check that map[node.parentId] exists
                    list[map[node.parentId]].children.push(node)
                } else {
                    roots.push(node)
                }
            }
            return roots
        },
        selectFolder(item) {
            console.log('selectFolder: ', item)
            const isFile = this.filesObject[item] ? true : false
            console.log('isFile: ', isFile)
            if (isFile) {
                console.log('Download file')
                this.download(this.filesObject[item])
            } else {
                this.currentFolder = this.directoriesObject[item]
            }
        },
        navigateBack() {
            try {
                if (this.currentFolder.parentId == 0) {
                    this.currentFolder = null
                } else {
                    const parentFolder = this.directoriesArray.find((x) => x.id == this.currentFolder.parentId)
                    console.log('parentFolder: ', parentFolder)
                    this.currentFolder = this.directoriesObject[parentFolder['name']]
                }
            } catch (error) {
                console.log('error: ', error)
            }
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
.item {
    margin: 10px;
}
.item:hover {
    cursor: pointer;
}
.file:hover {
    color: blue;
}
</style>
