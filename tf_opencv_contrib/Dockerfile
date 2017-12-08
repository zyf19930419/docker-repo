
FROM tensorflow/tensorflow:1.4.0-py3
MAINTAINER Kevin Zhao <kevin8093@126.com>

#Usage
#docker run -it -v ~/Workspace/tf_opencv_OKimg/:/notebooks -p 8889:8888 -p 6007:6006 kevin8093/tf_opencv_contrib

#using China mirror for ubuntu
RUN sed -i 's/http:\/\/archive\.ubuntu\.com\/ubuntu\//http:\/\/mirrors\.163\.com\/ubuntu\//g' /etc/apt/sources.list

RUN apt-get update

# Supress warnings about missing front-end. As recommended at:
# http://stackoverflow.com/questions/22466255/is-it-possibe-to-answer-dialog-questions-when-installing-under-docker
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y --no-install-recommends apt-utils

# Developer Essentials
RUN apt-get install -y --no-install-recommends git curl vim unzip openssh-client wget

# Build tools
RUN apt-get install -y --no-install-recommends build-essential cmake

# OpenBLAS
RUN apt-get install -y --no-install-recommends libopenblas-dev

#
# OpenCV Latest
#
# Dependencies
RUN apt-get install -y --no-install-recommends \
    libjpeg8-dev libtiff5-dev libjasper-dev libpng12-dev \
    libavcodec-dev libavformat-dev libswscale-dev libv4l-dev libgtk2.0-dev \
    liblapacke-dev checkinstall

# Get source from github
RUN git clone https://github.com/opencv/opencv.git /usr/local/src/opencv && \
    git clone https://github.com/opencv/opencv_contrib.git /usr/local/src/opencv_contrib

# Compile
RUN cd /usr/local/src/opencv && mkdir build && cd build && \
    cmake -D CMAKE_INSTALL_PREFIX=/usr/local \
          -D BUILD_TESTS=OFF \
          -D BUILD_opencv_gpu=OFF \
          -D BUILD_PERF_TESTS=OFF \
          -D WITH_IPP=OFF \
          -D OPENCV_EXTRA_MODULES_PATH=/usr/local/src/opencv_contrib/modules \
          -D OPENCV_EXTRA_MODULES_PATH=/usr/local/src/opencv_contrib/modules -D BUILD_opencv_xfeatures2d=OFF /usr/local/src/opencv \
          -D OPENCV_EXTRA_MODULES_PATH=/usr/local/src/opencv_contrib/modules -D BUILD_opencv_dnn_modern=OFF /usr/local/src/opencv \
          -D OPENCV_EXTRA_MODULES_PATH=/usr/local/src/opencv_contrib/modules -D BUILD_opencv_dnns_easily_fooled=OFF /usr/local/src/opencv \
          -D PYTHON_DEFAULT_EXECUTABLE=$(which python3) \
          .. && \
    make -j"$(nproc)" && \
    make install

#
# Cleanup
#
RUN apt-get clean && \
    apt-get autoremove

# NOTE: disable authentication token for convenience. DON'T DO THIS ON A PUBLIC SERVER.
RUN echo "c.NotebookApp.ip = '*'" \
         "\nc.NotebookApp.open_browser = False" \
         "\nc.NotebookApp.token = ''" \
         > /root/.jupyter/jupyter_notebook_config.py

EXPOSE 7777
         
