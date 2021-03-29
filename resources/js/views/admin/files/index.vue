<template>
    <div>
        <h1>Files</h1>
        directories: {{ directories }}<br /><br />
        files: {{ files }}<br /><br />
        directoriesObject: {{ directoriesObject }}<br /><br />
        directoriesArray: {{ directoriesArray }}<br /><br />
        <!-- items: {{ items }}<br /><br /> -->
        items2: {{ items2 }}<br /><br />
        <!-- <div v-for="(item, index) in directoriesObject" :key="index">{{ index }} --- {{ item }} <br /></div>
        <br /><br /> -->
        rootFolder: {{ rootFolder }}<br /><br />
        currentFolder: {{ currentFolder }}<br />
        opened: {{ opened }}<br />
        difference: {{ difference }}<br />
        selectedFolder: {{ selectedFolder }}<br />
        <!-- results: {{ results }}<br /> -->

        <v-row no-gutters>
            <v-col cols="4" style="border: 1px solid orange">
                <v-treeview shaped hoverable open-on-click return-object :items="items2" item-key="name" @update:open="updateOpen">
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
            <v-col :cols="drawer ? 8 : 8" style="border: 1px solid purple">
                currentFolder: {{ currentFolder }}<br />
                <span v-if="currentFolder">Content of {{ currentFolder['name'] }}:</span>
                <span v-else>Content of root</span><br />
                <v-btn small @click="navigateBack" v-if="currentFolder">&larr; Back</v-btn>
                <v-btn small @click="createFolder">Create folder</v-btn>
                <v-btn small @click="deleteFolder">Delete folder</v-btn>
                <v-row no-gutters class="item2" v-if="currentFolder">
                    <v-col cols="2" class="item" style="border: 1px dashed red; margin: 10px" v-for="(item, index) in currentFolder.children" :key="index">
                        <div class="text-center" v-if="!item.file" @click="oneClick(item)">
                            <v-icon x-large>mdi-folder</v-icon><br />
                            <small>{{ item.name }}</small>
                        </div>
                        <div class="text-center" @click="oneClick(item)" v-else>
                            <v-icon x-large>mdi-file-pdf</v-icon><br />
                            <small>{{ item.name }}</small>
                        </div>
                    </v-col>
                </v-row>
                <v-row no-gutters class="item2" v-else>
                    <v-col cols="2" class="item" style="border: 1px dashed blue; margin: 10px" v-for="(item, index) in rootFolder" :key="index">
                        <div class="text-center" v-if="!item.file" @click="oneClick(item)">
                            <v-icon x-large>mdi-folder</v-icon><br />
                            <small>{{ item.name }}</small>
                        </div>
                        <div class="text-center" @click="oneClick(item)" v-else>
                            <v-icon x-large>mdi-file-pdf</v-icon><br />
                            <small>{{ item.name }}</small>
                        </div>
                    </v-col>
                </v-row>
                <!-- <img src="/images/1920x1080.jpg" width="200" /> -->
                <!-- <img src="/storage/app/files/1920x1080.jpg" width="200" /> -->
                <!-- <div class="item" v-if="currentFolder">
                    <div style="border: 1px solid red; margin: 10px" v-for="(item, index) in currentFolder" :key="index" @click="selectFolder(item)">{{ item }}</div>
                </div> -->
            </v-col>
            <!-- Current selected folder -->
            <v-navigation-drawer v-model="drawer" :fixed="true" :temporary="true" :right="true" style="">
                <div style="border: 1px solid red;" v-if="selectedFile">
                    File info:<br />
                    Name: {{ selectedFile.name }}<br />
                    File: {{ selectedFile.file }}<br />
                    Size: {{ selectedFile.size }}<br />
                    Last modified: {{ selectedFile.lastModified }}
                    <v-btn small color="error" @click="deleteFile">Delete</v-btn>
                </div>
                <div style="border: 1px solid red;" v-if="selectedFolder">
                    Folder info:<br />
                    Name: {{ selectedFolder.name }}<br />
                    <v-btn small color="error" @click="deleteFolder">Delete</v-btn>
                    <v-btn small color="info" @click="renameFolder('new folder name')">Rename</v-btn>
                </div>
            </v-navigation-drawer>
        </v-row>
    </div>
</template>

<script>
import fileDownload from 'js-file-download'
export default {
    name: 'AdminFilesIndex',
    async created() {
        const { directories } = await this.$store.dispatch('folders/fetchFolders')
        const { files } = await this.$store.dispatch('files/fetchFiles')
        this.directories = directories
        this.files = files

        let separator
        // let index = 0
        let parentId
        let currentParentId
        let currentLength
        let obj = {}
        let path
        // Loop through directories
        for (let i = 0; i < this.directories.length; i++) {
            // console.log('directories[i]: ', this.directories[i])
            separator = this.directories[i].split('/')
            // console.log('separator: ', separator)¨
            if (separator.length === 1) {
                parentId = 0
                currentParentId = 0
            } else if (separator.length === currentLength) {
                parentId = currentParentId
            } else if (separator.length === currentLength + 1) {
                parentId = this.index
                currentParentId = this.index
                obj[separator.length] = currentParentId
            } else if (separator.length === currentLength - 1) {
                parentId = obj[separator.length]
            }
            this.index++
            currentLength = separator.length

            this.directoriesArray.push({
                name: separator[separator.length - 1],
                path: `/${this.directories[i]}`,
                id: this.index,
                parentId,
                // length: separator.length,
            })
            this.directoriesObject[this.directories[i]] = {
                name: separator[separator.length - 1],
                path: `/${this.directories[i]}`,
                id: this.index,
                parentId,
                // length: separator.length,
                children: [],
            }
            path = this.directories[i].substr(0, this.directories[i].lastIndexOf('/'))
            if (path) {
                // this.directoriesObject[path]['children'].push(separator[separator.length - 1])
                this.directoriesObject[path]['children'].push({
                    name: separator[separator.length - 1],
                    // file: false
                })
            }
        }

        // Loop through files
        for (let i = 0; i < this.files.length; i++) {
            separator = this.files[i].split('/')
            // console.log('separator: ', separator)

            path = this.files[i].substr(0, this.files[i].lastIndexOf('/'))
            parentId = path ? this.directoriesObject[path]['id'] : 0

            this.directoriesArray.push({
                name: separator[separator.length - 1],
                id: this.index + 1,
                parentId,
                path: this.files[i],
                file: true,
            })
            this.index++

            if (path) {
                // this.directoriesObject[path]['children'].push(separator[separator.length - 1])
                this.directoriesObject[path]['children'].push({
                    name: separator[separator.length - 1],
                    file: true,
                })
            }
        }

        // this.currentFolder = this.rootFolder
        // Create nested array
        // this.items = this.listToTree(this.directoriesArray)
    },
    data() {
        return {
            directories: [],
            files: [],
            directoriesObject: {},
            directoriesArray: [],
            filesObject: {},
            filesArray: [],
            index: 0,
            currentFolder: null,
            items: [],
            opened: [],
            selectedItem: null,
            selectedFile: null,
            selectedFolder: null,
            difference: null,
            drawer: null,
            items: [
                { title: 'Home', icon: 'mdi-view-dashboard' },
                { title: 'About', icon: 'mdi-forum' },
            ],
            // results: [],
            clicks: 0,
            timer: null,
        }
    },
    computed: {
        rootFolder() {
            // return this.items2.map((a) => a.name)
            return this.items2.map(({ name, file }) => ({ name, file }))
        },
        items2() {
            return this.listToTree(this.directoriesArray)
            // return []
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
                if (node.parentId !== 0) {
                    // if you have dangling branches check that map[node.parentId] exists
                    list[map[node.parentId]].children.push(node)
                } else {
                    roots.push(node)
                }
            }
            return roots
        },
        oneClick(event) {
            try {
                console.log('oneClick: ', event)
                this.clicks++
                if (this.clicks === 1) {
                    var self = this
                    this.timer = setTimeout(function () {
                        if (event.file) {
                            self.selectFile(event)
                        } else {
                            self.selectFolder(event)
                        }
                        self.clicks = 0
                    }, 300)
                } else if (event.file) {
                    clearTimeout(this.timer)
                    this.download(event)
                    this.clicks = 0
                } else {
                    clearTimeout(this.timer)
                    this.openFolder(event)
                    this.clicks = 0
                }
            } catch (error) {
                console.log('error: ', error)
            }
        },
        updateOpen(items) {
            console.log('updateOpen items: ', items)
            if (items && items.length > 0) {
                this.currentFolder = this.directoriesObject[items[items.length - 1]['path']]
            }
            if (this.opened.length > 0) {
                this.difference = this.opened.filter((x) => !items.map((item) => item.path).includes(x))[0]
            }
            this.opened = items.map((item) => item.path)
            if (this.difference && this.difference.length > 0) {
                let parent = this.difference.substr(0, this.difference.lastIndexOf('/'))
                if (parent) {
                    this.currentFolder = this.directoriesObject[parent]
                } else {
                    this.currentFolder = null
                }
                this.difference = null
            }
        },
        
        async selectFolder(folder) {
            try {
                console.log('selectFolder: ', folder)
                this.selectedFile = null
                this.drawer = true
                // this.selectedFolder = folder
                this.selectedFolder = this.directoriesObject[folder.name]
            } catch (error) {
                console.log('error: ', error)
            }
        },
        async selectFile(file) {
            try {
                console.log('selectFile: ', file)
                this.selectedFolder = null
                this.drawer = true
                this.selectedFile = file
                const filePath = encodeURI(`${this.currentFolder ? this.currentFolder.path : ''}/${file.name}`)
                const size = await this.$store.dispatch('files/fetchFileSize', { filePath })
                const lastModified = await this.$store.dispatch('files/fetchFileLastModified', { filePath })
                this.$set(this.selectedFile, 'size', size)
                this.$set(this.selectedFile, 'lastModified', lastModified)
            } catch (error) {
                console.log('error: ', error)
            }
        },
        openFolder(item) {
            try {
                console.log('openFolder: ', item)
                let path
                if (this.currentFolder) {
                    path = `${this.currentFolder.path}/${item.name}`
                } else {
                    path = item.name
                }
                if (item.file) {
                    console.log('Download file!')
                    // this.currentFolder = this.directoriesObject[path]
                    // path = `${this.currentFolder.path}/${item.name}`
                    // console.log('path1: ', path)
                    // this.download(path)
                    // } else if (this.currentFolder) {
                    //     path = `${this.currentFolder}/${item.name}`
                    //     this.currentFolder = this.directoriesObject[path]
                    //     console.log('path2: ', path)
                } else {
                    console.log('Move to folder', item.name)
                    this.currentFolder = this.directoriesObject[path]
                }
                console.log('path: ', path)
            } catch (error) {
                console.log('error: ', error)
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
                const filePath = encodeURI(`${this.currentFolder ? this.currentFolder.path : ''}/${file.name}`)
                const data = await this.$store.dispatch('files/fetchFile', { filePath })
                fileDownload(data.data, file.name)
            } catch (error) {
                console.log('error: ', error)
                alert('Sorry, an error occured when trying to download file.')
            }
        },
        async createFolder() {
            try {
                await this.$store.dispatch('folders/createFolder', { path: '/new folder2' })
                this.directoriesArray.push({
                    name: 'new folder2',
                    id: this.index + 1,
                    parentId: 0,
                    path: '/new folder2',
                })
                alert('Folder created successfully!')
            } catch (error) {
                console.log('error: ', error)
            }
        },
        async renameFolder(newName) {
            try {
                console.log('renameFolder ', this.selectedFolder, newName)
                // return
                await this.$store.dispatch('folders/renameFolder', {
                    path: this.selectedFolder.path,
                    newName: 'new folder name'
                })
            } catch (error) {
                console.log('error: ', error)
                alert('Error renaming folder')
            }
        },
        async deleteFolder() {
            try {
                await this.$store.dispatch('folders/deleteFolder', { path: '/new folder/new folder3' })
                alert('Folder deleted successfully!')
            } catch (error) {
                console.log('error: ', error)
                console.log('error.response: ', error.response)
                console.log('error.response.data: ', error.response.data)
            }
        },
        async deleteFile() {
            try {
                await this.$store.dispatch('files/deleteFile', { path: '/Webstamps.pdf' })
            } catch (error) {
                console.log('error: ', error)
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
