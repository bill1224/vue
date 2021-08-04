<template>
  <div>
    <b-table striped hover :items="items" :fields="fields" @row-clicked="rowClick"></b-table>
  </div>
</template>

<script>
import data from "@/data";

// sort는 인자로 함수를 받는다 -
// 오름차순 : a-b
// 내림차순 : b-a

//map은 배열에 있는 값들을 하나하나 꺼내서, 특정 함수를 적용해 다시 배열로 만들어주는 것
//filter는 배열에 있는 원소들중에서 조건에 맞는 원소들만을 모아서 배열로 만들어주는 것 
//map 함수를 이용해서 items = content_id의 내림차순으로 정렬된 data.Content의 원소들을 하나하나 꺼내어, user_name이라는 key와 value를 추가한다.
//여기서 user_name의 value는 filter 함수를 이용해서 data.User에 있는 원소를 하나하나 꺼내서 data.User 원소에 있는 user_id 값과
// data.Content에 있는 user_id값과 일치하는 값을 필터링해서 배열로 만들어준다. 
// 그런데 data.User에서 user_id는 인덱스와 같기 때문에, 하나의 원소값 밖에 존재하지 않는다. 그러므로 [0]으로 접근해서 .name을 가져오는 것이다. 


  export default {
    name: 'board',
    data() {
      let items = data.Content.sort((a, b) => {return b.content_id - a.content_id})
      items = items.map(contentItem => {return {...contentItem, user_name: data.User.filter(userItem => userItem.user_id === contentItem.user_id)[0].name}})
      return {
          fields: [
              {
                  key: 'content_id',
                  label: '글번호'
              },
              {
                  key: 'title',
                  label: '제목'
              },
              {
                  key: 'created_at',
                  label: '작성일'
              },
              {
                  key: 'user_name',
                  label: '글쓴이'
              },
          ],
          items: items    
      }
    },
    methods: {
        rowClick(item) {
            this.$router.push({
                path: `/board/free/detail/${item.content_id}`
            })
        }

    }
  }
</script>