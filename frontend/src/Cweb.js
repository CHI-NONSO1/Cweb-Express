import React from 'react'
import "./Cweb.css";
import styled from 'styled-components'
import { NavLink } from 'react-router-dom';

export default function Cweb() {
  return (
    <Container>
<UserWrap>
<NavLink

onClick={() =>{
}}
to={`/register`}
>
Register
</NavLink>
/
<NavLink

onClick={() =>{
}}
to={`/login`}
>
Login
</NavLink>
</UserWrap>
    </Container>
  )
}

const Container = styled.div`
width:100%;
height:100%;
position:absolute;
top:0;
left:0;
bottom:0;
right:0;
overflow-x:hidden;
overflow-y:hidden;
background:navy;

`

const UserWrap = styled.div`
width:20%;
height:5%;
position:absolute;
top:0;
right:0;
background:#fff;



`

