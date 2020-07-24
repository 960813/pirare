[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/960813/pirare">
    <img src="https://github.com/960813/pirare/blob/master/_data/README.png?raw=true" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">PIRARE(Pinterest semi clone with PHP)</h3>

  <p align="center">
    영남이공대학교 컴퓨터정보과 2019학년도 1학년 2학기(원래는 2학년 1학기 강의) PHP 기말 실기시험(프로젝트 제작) 평가를 위해 제작된 프로젝트입니다.    
    <br />
    <a href="https://github.com/960813/pirare"><strong>Explore the Github »</strong></a>
    <br />
    <br />
    <a href="https://pirare.jupiterflow.com/">View Demo</a>
    ·
    <a href="https://github.com/960813/pirare/issues">Report Bug</a>
    ·
    <a href="https://github.com/960813/pirare/issues">Request Feature</a>
  </p>
</p>


<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about)
  * [Main Features](#main-features)
  * [Built With](#built-With)
* [스스로 가장 잘 했다고 생각하는 부분](#스스로-가장-잘-했다고-생각하는-부분)
  * [FrontEnd와 BackEnd의 분리](#frontend와-backend의-분리)
  * [Masonry 스타일 레이아웃 적용](#masonry-스타일-레이아웃-적용)
* [프로젝트 수행 후 스스로의 평가와 성과](#프로젝트-수행-후-스스로의-평가와-성과)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About
[![Pirare Screen Shot](https://github.com/960813/pirare/blob/master/_data/001.png?raw=true)](https://jupiterflow.com/project/3)
[![Pirare Screen Shot](https://github.com/960813/pirare/blob/master/_data/002.png?raw=true)](https://jupiterflow.com/project/3)
[![Pirare Screen Shot](https://github.com/960813/pirare/blob/master/_data/003.png?raw=true)](https://jupiterflow.com/project/3)
[![Pirare Screen Shot](https://github.com/960813/pirare/blob/master/_data/004.png?raw=true)](https://jupiterflow.com/project/3)
[![Pirare Screen Shot](https://github.com/960813/pirare/blob/master/_data/005.png?raw=true)](https://jupiterflow.com/project/3)

PHP를 이용해 Pinterest 서비스를 클론한 웹 개발 프로젝트입니다.

### Main Features
* 게시글 목록 조회·작성·조회·수정·삭제·다운로드·검색
* 쪽지 목록 조회·조회·작성·답장·삭제
* 회원 가입·로그인·로그아웃·수정·탈퇴
* 댓글 작성·조회·수정·삭제
* 문의
* 번들(카테고리 개념) 목록조회·소속 이미지 조회

### Built With
* HTML5
* JQuery
* PHP
* MariaDB

## 스스로 가장 잘 했다고 생각하는 부분
### FrontEnd와 BackEnd의 분리
프론트엔드란 웹사이트 중 사용자가 직접 상호작용을 하게 되는 부분을 뜻한다. 이는 글꼴부터 색상, 드롭-다운 메뉴 및
슬라이더에 이르기까지 인터넷에서 보게 되는 모든 것들의 집합이다. 백엔드란 서버, 응용프로그램 및 데이터베이스 등
구성요소들이 서로 통신하여 작동할 수 있게끔 하는 것이다. 이렇듯 프론트엔드와 백엔드는 개념적으로 다른 목표를 추구하기
때문에 개발 방법과 개발 결과물의 실행 결과가 상반되는 차이점을 지니기 때문에 실무에서는 철저히 구분하는 편이다.  
또한 이번 프로젝트 개발에 사용한 PHP의 경우 코드를 동기, 순차적으로 싱글 스레드에서 실행한다는 특징을 가지고 있다.
그 결과 사용자의 요청을 처리하고 응답하는 과정에서 새로 고침(reload)현상이 발생한다. 이는 UX(유저경험, User
Experience)를 저하시키는 가장 대표적인 요인으로서 모든 요청에 응답하기 위해 페이지가 새롭게 로드되는 것은 바람직하지
못하다. 이러한 문제점을 해결하기 위해선 모든 응답을 비동기적으로 처리 해주어야 할 필요성이 있다. 웹 프로그래밍에서
PHP를 비동기적으로 요청하고, 응답 결과를 받아오는 방법 중 가장 대표적인 것이 자바스크립트의 Ajax이다. 특히 이러한
Ajax는 웹 페이지를 보다 동적으로 표현하기 위해 등장한 JQuery 라이브러리에 사용하기 좋게끔 프로그래밍 되어 포함 되어
있다.  
최종적으로 웹 페이지를 동적, 비동기적으로 작동할 수 있게끔 도와주는 JQuery를 프론트단에서 사용하고, 서버 및
데이터베이스와 통신하기 위한 언어로서 PHP를 사용하여 UX를 저하시키지 않으면서 서버에 요청하는 웹 서비스를
개발하였다.

### Masonry 스타일 레이아웃 적용
Masonry 스타일 레이아웃은 벽돌을 쌓듯 차곡차곡 비율에 맞게 조적식으로 구성된 레이아웃을 말한다. 어떤 비율의 카드가
들어와도 공간을 알맞게 찾아간다는 점에서 일반적인 카드 레이아웃과는 차이가 있다. 여러 방식의 이미지 리스트 레이아웃을
검토해보던 중 가장 적합한 레이아웃이라고 판단하여 이를 채택해 사용하였다.  
이를 구현하기 위해 정말 다양한 방법을 사용해보았다. 첫 번째로, CSS Flexbox만을 이용해 만드는 방식이다. 이는 가장
간단하지만 한계가 있었다. 카드를 수직 방향으로만 정렬하려한다면 가장 간단하고 알맞은 방식일 수 있으나, 수평하게 정렬
할 수 없다는 점이었다. 두 번째는 CSS Grid와 자바스크립트를 이용한 방식이다. grid-gap 스타일로 row에 대한 높이를
설정하고, 자바스크립트로 이미지 각각의 높이를 불러온 뒤 해당하는 이미지가 차지할 row의 개수를 계산해 grid-row-end
스타일로 정해주는 방식이다. 이 방식은 카드의 개수가 적을 경우 고려해볼만한 방식이다. 하지만 개수가 많으면 문제가 된다.
일단 grid가 많으면 많아질수록 성능이 급격하게 저하되는 것은 물론이고, 이러한 성능 저하 때문에 브라우저에서 최대 row의
개수를 이미 정해두어 그 이상의 내용은 잘리게 된다. Flexbox, Grid를 이용한 손 쉬운 구현이 불가능해진 것이다. 결국 나는
최후의 방법으로 남겨두었던 Div Box의 left, top 속성을 활용하기로 했다. 추가하고자 하는 카드의 Position을 Absolute로
지정해주고 top과 left 값으로 어떤 값이 포함 되어야 하는가를 자바스크립트로 계산해주어 이를 구현하였다.

<!-- USAGE EXAMPLES -->
## 프로젝트 수행 후 스스로의 평가와 성과
이 프로젝트의 개발에 앞서, 데이터베이스를 연동한 PHP 결과물의 종류에 어떤 것이 있는지 탐색을 해보았다. 그 결과 두
가지 종류의 가장 대표적인 프로젝트를 확인할 수 있었다. 첫 번째는 웹 사이트에 등록된 회원의 정보와 제목, 내용, 첨부파일
등을 포함한 게시글의 정보를 데이터베이스에 담는 커뮤니티 스타일의 프로젝트였다. 이는 일반 사용자의 요청(입력)에 따라
대부분의 데이터베이스가 갱신될 수 있다는 특징이 있었다. 두 번째는 쇼핑몰의 상품 정보, 학습 웹사이트의 문제 정보 등 일반
사용자의 요청(입력)에 따라 갱신되지 않는 정보를 갖는 프로젝트가 있었다. 전자의 경우 사용자의 입력을 PHP에서 처리하여
데이터베이스에 반영함으로써 UX를 즉각적으로 향상시킬 수 있다는 장점과 일부의 경우 데이터의 중복성이 발생할 수 있다는
단점이 있었으며, 후자의 경우 DBA 혹은 DB실무자에 의해 체계적으로 작성 데이터를 사용하기 때문에 중복성의 문제가
발생하지 않는다는 장점이 있었다.  
이에 사용자의 UX는 극대화시키면서 데이터의 중복성으로 인한 문제가 발생하지 않게끔 데이터베이스를 구성하고자하였다.
하지만 프로젝트를 개발하면서 예상치 못한 문제가 발생하여 데이터베이스의 구조를 수차례 변경하는 등 고초를 겪었다. 이를
통해 다음 프로젝트 진행시에는 **①프로젝트의 설계(레이아웃, 기능 등) ②기능 구현에 필요한 데이터 모델링 ③실제적 테이블
구조화 ④테이블간의 관계 정의** 등의 순서를 지켜 데이터베이스의 구조를 재정의하는 빈도를 최소화 하고자한다.  
또한 SQL과 PHP 코드의 최적화 보다는 Front(JQuery)/Back(PHP) 단의 단순 코드 작성과 DataBase 구조화에만 신경을
썼다는 아쉬움이 많이 남았다. 특히 SQL의 경우 JOIN 등의 질의 문을 이용한다면 더 쉽게 처리할 수 있었던 질의 절차가
번거로워져 프로젝트의 개발이 지연되고 장기화하였기 때문에 더욱더 아쉬움이 남는다. 그렇기에 이번 학기가 끝나면 SQLD
자격 취득을 목표로 실질적인 데이터 모델링 기법과 SQL 작성 기법에 대해 공부하며 부족한 점을 보완 해보고자 한다.

<!-- CONTRIBUTING -->
## Contributing
This repository is not managed.

<!-- LICENSE -->
## License
Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact
JIN TAEYANG - sun@jupiterflow.com

Project Link: [https://github.com/960813/pirare](https://github.com/960813/pirare)


<!-- Acknowledgements -->
## Acknowledgements
* ajax



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/960813/pirare?style=flat-square
[contributors-url]: https://github.com/960813/pirare/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/960813/pirare?style=flat-square
[forks-url]: https://github.com/960813/pirare/network/members

[stars-shield]: https://img.shields.io/github/stars/960813/pirare?style=flat-square
[stars-url]: https://github.com/960813/pirare/stargazers

[issues-shield]: https://img.shields.io/github/issues/960813/pirare?style=flat-square
[issues-url]: https://github.com/960813/pirare/issues

[license-shield]: https://img.shields.io/github/license/960813/pirare?style=flat-square
[license-url]: https://github.com/960813/pirare/blob/master/LICENSE

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=flat-square&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/jupiterflow

[product-screenshot]: https://github.com/960813/pirare/blob/master/_data/000.png?raw=true