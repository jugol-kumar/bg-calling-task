<script setup lang="ts">

</script>

<template>

  <nav
      class="py-5 border-b-default border-solid border-gray-200 z-10 w-full bg-inherit lg:fixed"
      id="topnav"
  >
    <div class="mx-auto max-w-7xl  lg:px-8">
      <div class="w-full flex flex-col lg:flex-row">
        <div
            class="hidden w-full lg:flex justify-between max-lg:bg-white py-5 max-lg:mt-1 max-lg:px-4 max-lg:shadow-lg max-lg:shadow-gray-200 max-lg:h-auto max-lg:overflow-auto transition-all duration-500 delay-200 "
            id="navbar">
          <ul
              class="flex lg:items-center max-lg:gap-4 max-lg:mb-4 flex-col mt-4 lg:flex-1 md:mt-0 lg:flex-row"
          >
            <li>
              <RouterLink
                  to="/"
                  class="text-gray-500 text-sm font-medium hover:text-prime-blue-700 transition-all duration-500 mb-2 block lg:mr-6 lg:text-base md:mb-0 md:mr-3 hover:text-gray-900"
              >Home
              </RouterLink
              >
            </li>
            <li>
              <a
                  href="https://jugol.ctpbd.com"
                  class="text-gray-500 text-sm font-medium hover:text-prime-blue-700 transition-all duration-500 mb-2 block lg:mr-6 lg:text-base md:mb-0 md:mr-3 hover:text-gray-900"
              >About me</a
              >
            </li>
            <li class="relative">
              <a href="https://github.com/jugol-kumar"
                 target="_blank"
                  class="flex items-center justify-between text-gray-500 text-sm lg:text-base font-medium hover:text-prime-blue-700 transition-all duration-500 lg:mr-6 lg:mb-0 mr-auto lg:text-left  lg:m-0 hover:text-gray-900"
              >
                Github
              </a>
            </li>
            <li class="relative">
              <a href="https://bd.linkedin.com/in/jugol-kumar-5855b6208"
                 target="_blank"
                  class="flex items-center justify-between text-gray-500 text-sm lg:text-base font-medium hover:text-prime-blue-700 transition-all duration-500 lg:mr-6 lg:mb-0 mr-auto lg:text-left  lg:m-0 hover:text-gray-900"
              >
                Linkedin
              </a>
            </li>
          </ul>
          <a href="https://pagedone.io/" class="hidden lg:flex items-center">
            BD CALLING TASK
          </a>
          <div
              class="flex lg:items-center justify-start flex-col lg:flex-row max-lg:gap-4 lg:flex-1 lg:justify-end"
          >
            <RouterLink to="/login"
                class="bg-indigo-600 text-white rounded-full cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 py-3 px-6 text-sm lg:ml-5 hover:bg-indigo-700"
            >
              Sign In
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <section
      class="pt-8 lg:pt-32 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-center bg-cover"
  >
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative text-center">
      <div
          class="border border-indigo-600 p-1 w-60 mx-auto rounded-full flex items-center justify-between mb-4"
      >
          <span class="font-inter text-xs font-medium text-gray-900 ml-3"
          >System Build By Jugol Kumar</span
          >
        <a
            href="https://jugol.ctpbd.com/"
            target="_blank"
            class="w-8 h-8 rounded-full flex justify-center items-center bg-indigo-600"
        >
          <svg
              width="17"
              height="16"
              viewBox="0 0 17 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
          >
            <path
                d="M2.83398 8.00019L12.9081 8.00019M9.75991 11.778L13.0925 8.44541C13.3023 8.23553 13.4073 8.13059 13.4073 8.00019C13.4073 7.86979 13.3023 7.76485 13.0925 7.55497L9.75991 4.22241"
                stroke="white"
                stroke-width="1.6"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
          </svg>
        </a>
      </div>
      <h1
          class="max-w-2xl mx-auto text-center font-manrope font-bold text-4xl text-gray-900 mb-5 md:text-5xl leading-[50px]"
      >
        Build a Full-Stack Role-Based Access Control

        <span class="text-indigo-600">(RBAC) System</span>
      </h1>
      <p
          class="max-w-sm mx-auto text-center text-base font-normal leading-7 text-gray-500 mb-9"
      >
        Multiple Module Wise Role Permission User Management System
      </p>
      <RouterLink
          to="/login"
          class="w-full md:w-auto mb-14 inline-flex items-center justify-center py-3 px-7 text-base font-semibold text-center text-white rounded-full bg-indigo-600 shadow-xs hover:bg-indigo-700 transition-all duration-500"
      >
        Started From here
        <svg
            class="ml-2"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
          <path
              d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
          />
        </svg>
      </RouterLink>
      <div class="flex justify-center">
        <img
            src="https://i.ibb.co/SBgWGz8/img.png"
            alt="Dashboard image" class="rounded-t-3xl"
        />
      </div>
    </div>
  </section>
</template>
