FROM arm32v7/ubuntu:16.04

LABEL maintainer="Kevin Zhao <kevin8093@126.com>"


RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    curl \
    libfreetype6-dev \
    libpng12-dev \
    libzmq3-dev \
    pkg-config \
    python \
    python-dev \
    python-pillow \
    python-h5py \
    python-numpy \
    python-matplotlib \
    python-scipy \
    python-sklearn \
    python-pandas \
    rsync \
    software-properties-common \
    unzip \
    && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN curl -O https://bootstrap.pypa.io/get-pip.py && \
    python get-pip.py && \
        rm get-pip.py

RUN pip --no-cache-dir install \
     ipykernel \
     jupyter \
     && \
     python -m ipykernel.kernelspec

ADD tensorflow-1.3.0-cp34-cp34m-linux_armv7l.whl .

RUN pip --no-cache-dir install tensorflow-1.3.0-cp27-none-linux_armv7l.whl && \
    rm -f tensorflow-1.3.0-cp27-none-linux_armv7l.whl

COPY jupyter_notebook_config.py /root/.jupyter/

COPY notebooks /notebooks

COPY run_jupyter.sh /
RUN chmod +x /run_jupyter.sh


EXPOSE 6006

EXPOSE 8888

WORKDIR "/notebooks"

CMD ["/run_jupyter.sh", "--allow-root"]
