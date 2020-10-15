<script>
  import {ajUsers} from "./users.js"
  import User from "./User.svelte"

  let frmSaveUser
  let txtUserName
  let txtUserLastName
  let from = 0

  const saveUser = async () => {
    let con = await fetch(`http://localhost/back/api-create-user.php`,{
      method : "POST",
      body : new FormData(frmSaveUser)
    })
    let res = await con.json()
    $ajUsers = [...res, ...$ajUsers]
    txtUserName.value = ""
    txtUserName.focus()
    txtUserLastName.value = ""
  }

  const getMoreUsers = async () => {
    let connection = await fetch(`http://localhost/back/api-get-from-to-users.php?from=${from}`)
    let res = await connection.json()
    from += 2
    for(let i = 0; i < $ajUsers.length; i++){
      for(let y = 0; y < res.length; y++){
        if( $ajUsers[i]._key == res[y]._key ){
          res = res.splice(i, 1)
        }
      }
    }
    $ajUsers = [...res.reverse(), ...$ajUsers]
  }
  getMoreUsers()

</script>


<section>

  <form bind:this={frmSaveUser} on:submit|preventDefault={saveUser} autocomplete="off">
    <input bind:this={txtUserName} name="name" type="text" value="" placeholder="user name">
    <input bind:this={txtUserLastName} name="lastName" type="text" value="" placeholder="user last name">
    <button id="btnSave">Save</button>
  </form>

  <button id="btnMoreUsers" on:click={getMoreUsers}>
    Show more users
  </button>

</section>

  <div id="users">
    {#each $ajUsers as jUser (jUser._key)}
      <User {jUser} />
    {/each}
  </div>

  <div>
    <!-- {JSON.stringify($ajUsers)} -->
  </div>



<style>
  section{
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 0.5rem;
    padding: 1rem;
  }
  form{
    display: grid;
    grid-template-columns: 10fr 10fr 1fr;
    grid-gap: 0.5rem;
  }
  #btnSave{
    color: white;
    background: rgba(29, 161, 242, 1);
  }
  #btnMoreUsers{
    color: white;
    background: rgba(101,119,134, 1);
  }
</style>